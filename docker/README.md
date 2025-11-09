# Docker Template — PHP 8.3, Nginx, MySQL (+ Redis, Memcached)

Template environment server untuk workshop migrasi CodeIgniter ke Laravel. Mendukung multi-proyek Laravel dalam satu stack Docker dengan konfigurasi terpisah per proyek.

# Docker Template — PHP 8.3, Nginx, MySQL (+ Redis, Memcached)

Template environment server untuk workshop migrasi CodeIgniter ke Laravel. Mendukung multi-proyek Laravel dalam satu stack Docker dengan konfigurasi terpisah per proyek.

## Komponen

- **PHP 8.3** (php-fpm) dengan ekstensi: pdo_mysql, mbstring, bcmath, intl, zip, gd, opcache, redis, memcached
- **Nginx** sebagai web server
- **MySQL 8** dengan persistent volume
- **Redis** (optional, via profile)
- **Memcached** (optional, via profile)
- **Supervisord** untuk menjalankan php-fpm, queue worker, dan scheduler
- **Platform**: linux/amd64 (kompatibel penuh dengan server Linux production)

## Struktur Direktori

```text
./docker/
  ├── docker-compose.yml       # Definisi services
  ├── .env                      # Environment variables (copy dari .env.example)
  ├── .env.example              # Template environment
  ├── README.md                 # Dokumentasi ini
  ├── nginx/
  │   ├── default.conf          # app.localhost (root: ./app/public)
  │   ├── project-a.conf        # project-a.local
  │   └── project-b.conf        # project-b.local
  └── php/

      ├── Dockerfile            # PHP 8.3 + ekstensi + composer + supervisor
      ├── php.ini               # Konfigurasi PHP (opcache, limits)
      ├── supervisord.conf      # Main supervisor config
      └── supervisor.conf       # Queue worker & scheduler programs

  ./projects/                     # Mount point untuk proyek Laravel (dulu: ./app/)
  ├── project-a/
  │   ├── .env                  # Config: project_a_db, Redis, Queue Redis
  │   ├── public/
  │   └── artisan
  └── project-b/
      ├── .env                  # Config: project_b_db, Memcached, Queue Database
      ├── public/
      └── artisan
```

---

## Quick Start

### 1) Setup Environment

```zsh
cd docker
cp .env.example .env
```

Edit `docker/.env` jika perlu (default sudah siap pakai):

- `NGINX_HTTP_PORT=80`
- `APP_PRIMARY=project-a` (proyek yang menjalankan queue worker & scheduler)

### 2) Start Docker Stack

```zsh
# Start dengan Redis dan Memcached
docker compose --profile redis --profile memcached up -d --build
```

Container yang berjalan:

- `ci2laravel_php` (PHP 8.3 + supervisor)
- `ci2laravel_nginx` (Nginx)
- `ci2laravel_mysql` (MySQL 8)
- `ci2laravel_redis` (Redis)
- `ci2laravel_memcached` (Memcached)

### 3) Setup Hosts File (Wajib untuk .local domain)

```zsh
sudo sh -c 'echo "\n127.0.0.1 project-a.local project-b.local" >> /etc/hosts'
```

### 4) Install Laravel untuk Kedua Proyek

```zsh
# Masuk ke container PHP (dalam folder `projects`)
docker compose exec php bash

# Install Project A
cd /var/www/html/project-a
composer create-project laravel/laravel . --prefer-dist
php artisan key:generate

# Install Project B
cd /var/www/html/project-b
composer create-project laravel/laravel . --prefer-dist
php artisan key:generate

exit
```

### 5) Setup Database

```zsh
# Buat database untuk kedua proyek (tanpa warning password)
docker compose exec -e MYSQL_PWD=rootsecret mysql \
  mysql -uroot -e "
  CREATE DATABASE project_a_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  CREATE DATABASE project_b_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  GRANT ALL PRIVILEGES ON project_a_db.* TO 'app'@'%';
  GRANT ALL PRIVILEGES ON project_b_db.* TO 'app'@'%';
  FLUSH PRIVILEGES;"
```

Catatan:

- MySQL menampilkan peringatan "Using a password on the command line interface can be insecure" jika password diberikan langsung di argumen `-p...`.
- Snippet di atas menggunakan environment variable `MYSQL_PWD` agar tidak memunculkan peringatan tersebut. Ini cukup untuk lingkungan lokal/dev.
- Alternatif lebih aman: gunakan prompt interaktif (akan meminta password saat runtime):

```zsh
docker compose exec mysql bash -lc 'mysql -uroot -p -e "SHOW DATABASES;"'
```

- Alternatif lain: gunakan file konfigurasi sementara (tidak terekam di history):

```zsh
docker compose exec mysql bash -lc '
  cat > /tmp/my.cnf <<EOF
  [client]
  user=root
  password=rootsecret
  host=127.0.0.1
  EOF
  mysql --defaults-extra-file=/tmp/my.cnf -e "SHOW DATABASES;"
  rm -f /tmp/my.cnf
'
```

### 6) Jalankan Migrasi

```zsh
docker compose exec php bash -c "cd /var/www/html/project-a && php artisan migrate"
docker compose exec php bash -c "cd /var/www/html/project-b && php artisan migrate"

### (Penjelasan) Dari mana asal database `app`?

Saat pertama kali container MySQL dijalankan dengan image resmi (`mysql:8.0`), ia memeriksa apakah direktori data kosong. Jika kosong (baru pertama kali), entrypoint bawaan MySQL akan:

1. Inisialisasi data directory (dalam folder `projects`).
2. Membuat user & database awal sesuai environment variables yang diberikan.

Pada file `docker/.env` kita punya variabel:

```env
MYSQL_DATABASE=app
MYSQL_USER=app
MYSQL_PASSWORD=secret
MYSQL_ROOT_PASSWORD=rootsecret
```

Karena `MYSQL_DATABASE=app`, MySQL otomatis membuat database bernama `app` saat bootstrap pertama. Jadi database `app` bukan dibuat manual oleh kita, tetapi dibuat otomatis oleh mekanisme entrypoint MySQL.

Kalau Anda menghapus container tetapi tidak menghapus volumenya (`mysql-data`), database itu akan tetap ada karena disimpan di volume. Hanya jika Anda jalankan:

```zsh
docker compose down -v
```

baru volume (dan seluruh data termasuk database `app`) akan hilang, lalu ketika `up` lagi akan dibuat ulang sesuai variabel.

#### Mengubah atau menghilangkan database default

Jika tidak ingin memakai database `app`, ada dua pendekatan:

1. Ganti variabel di `docker/.env` sebelum pertama kali start (dalam folder `projects`):

   ```env
   MYSQL_DATABASE=ci2laravel
   ```

   Lalu `docker compose up -d` (database baru `ci2laravel` akan otomatis dibuat).

1. Jika sudah terlanjur berjalan dan volume berisi data, Anda bisa:
   - Drop database lama:

     ```zsh
     docker compose exec -e MYSQL_PWD=rootsecret mysql mysql -uroot -e "DROP DATABASE app;"
     ```

   - Atau hapus volume dan start ulang (menghilangkan semua data):

     ```zsh
     docker compose down -v
     docker compose up -d
     ```

> Catatan: Untuk multi-proyek kita tetap butuh database terpisah `project_a_db` dan `project_b_db`. Database `app` bisa diabaikan atau digunakan untuk testing cepat.

```text

### 7) Akses Aplikasi

- **Project A**: <http://project-a.local>
- **Project B**: <http://project-b.local>

---

## Konfigurasi Per Proyek

### Project A (`app/project-a/.env`)

```bash
APP_NAME="Project A"
APP_URL=http://project-a.local

DB_HOST=mysql
DB_DATABASE=project_a_db
DB_USERNAME=root
DB_PASSWORD=rootsecret

CACHE_DRIVER=redis          # Menggunakan Redis
QUEUE_CONNECTION=redis      # Queue via Redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PORT=6379
```

### Project B (`app/project-b/.env`)

```bash
APP_NAME="Project B"
APP_URL=http://project-b.local

DB_HOST=mysql
DB_DATABASE=project_b_db
DB_USERNAME=root
DB_PASSWORD=rootsecret

CACHE_DRIVER=memcached      # Menggunakan Memcached
QUEUE_CONNECTION=database   # Queue via database
SESSION_DRIVER=file

MEMCACHED_HOST=memcached
```

### Perbedaan Setup

| Fitur | Project A | Project B |
|-------|-----------|-----------|
| Database | `project_a_db` | `project_b_db` |
| Cache | Redis | Memcached |
| Queue | Redis (+ worker aktif) | Database |
| Session | Redis | File |
| Domain | project-a.local | project-b.local |

---

## Environment: Development, Staging, Production

### Strategi 1: File .env Terpisah (Recommended)

Buat file environment berbeda:

```text
docker/
  .env.local          # development (default)
  .env.staging        # staging
  .env.production     # production
```

Jalankan dengan:

```zsh
# Development
docker compose up -d
# Staging
docker compose --env-file .env.staging up -d

# Production
docker compose --env-file .env.production up -d
```

### Strategi 2: Override Files

```zsh
# Staging
docker compose -f docker-compose.yml -f docker-compose.staging.yml up -d

# Production
docker compose -f docker-compose.yml -f docker-compose.production.yml up -d
```

### Best Practices untuk Production

1. **Database**: Gunakan managed DB service (RDS, Cloud SQL), set `DB_HOST` ke endpoint eksternal
2. **Security**:
   - `APP_DEBUG=false`
   - Jangan expose MySQL port ke host
   - Gunakan TLS/SSL di Nginx
   - User non-root di container
3. **Performance**:
   - Aktifkan `php artisan config:cache` dan `route:cache`
   - Set `opcache.validate_timestamps=0`
4. **Scheduler**: Gunakan cron sistem, bukan loop shell
5. **Secrets**: Gunakan secrets manager (Vault, AWS Secrets Manager), jangan commit `.env.production`

---

## Commands Berguna

### Menjalankan Artisan

```zsh
# Project A
docker compose exec php bash -c "cd /var/www/html/project-a && php artisan migrate"
docker compose exec php bash -c "cd /var/www/html/project-a && php artisan db:seed"
docker compose exec php bash -c "cd /var/www/html/project-a && php artisan route:list"

### Mode Root-Only untuk MySQL (Opsional)

Anda dapat (seperti sekarang) menggunakan hanya user `root` untuk semua koneksi aplikasi. Ini sederhana untuk workshop, namun TIDAK direkomendasikan untuk production.

Kelebihan:
1. Setup lebih cepat (tidak perlu GRANT per user).
2. Mengurangi potensi kebingungan credential.
Risiko / Kekurangan:
1. Jika kredensial root bocor, seluruh database kompromi.
2. Sulit menerapkan prinsip least privilege.
3. Auditing & revoke akses jadi kasar (all-or-nothing).

Cara mengaktifkan (sudah diterapkan):
1. Komentari `MYSQL_USER` dan `MYSQL_PASSWORD` di `docker/.env`.
2. Ubah `DB_USERNAME` / `DB_PASSWORD` di `.env` proyek menjadi `root` / `rootsecret`.
3. Restart MySQL jika sebelumnya sudah dibuat user tambahan (opsional: `docker compose down && docker compose up -d`).

Cara kembali ke mode user terpisah:
1. Un-komentari `MYSQL_USER` dan `MYSQL_PASSWORD` di `docker/.env`.
2. Tambahkan (opsional) `MYSQL_DATABASE=app` jika ingin database default.
3. Jalankan ulang stack: `docker compose down && docker compose up -d`.
4. Set `DB_USERNAME=app`, `DB_PASSWORD=secret` di masing-masing proyek.

Tips keamanan production:
- Gunakan user berbeda per aplikasi dengan hak terbatas (`SELECT`, `INSERT`, `UPDATE`, `DELETE` saja bila perlu).
- Simpan kredensial di secret manager, bukan di file `.env` yang ter-commit.
- Non-ekspos port MySQL ke host publik.


# Project B
docker compose exec php bash -c "cd /var/www/html/project-b && php artisan tinker"
```

### Install Package

```zsh
docker compose exec php bash -c "cd /var/www/html/project-a && composer require spatie/laravel-permission"
```

### Logs & Monitoring

```zsh
# Lihat semua logs
docker compose logs -f

# Logs PHP/Supervisor
docker compose logs -f php

# Logs Nginx
docker compose logs -f nginx

# Status Supervisor (queue worker & scheduler)
docker compose exec php supervisorctl status

# Masuk ke container
docker compose exec php bash
docker compose exec mysql bash

docker compose exec redis redis-cli ping

# Test Memcached
docker compose exec memcached sh -c "echo stats | nc localhost 11211"
```

### Clear Cache

```zsh
docker compose exec php bash -c "cd /var/www/html/project-a && php artisan cache:clear && php artisan config:clear && php artisan route:clear"
```

### Permission Fix

```zsh
docker compose exec php bash -c "
chown -R www-data:www-data /var/www/html/project-a/storage /var/www/html/project-a/bootstrap/cache
chown -R www-data:www-data /var/www/html/project-b/storage /var/www/html/project-b/bootstrap/cache
chmod -R 775 /var/www/html/project-a/storage /var/www/html/project-a/bootstrap/cache
chmod -R 775 /var/www/html/project-b/storage /var/www/html/project-b/bootstrap/cache
"
```

---

## Queue & Scheduler

### Default: Project A (APP_PRIMARY)

Supervisor menjalankan queue worker dan scheduler untuk proyek yang ditentukan di `APP_PRIMARY` (default: `project-a`).

Cek status:

```zsh
docker compose exec php supervisorctl status

# Output:
# php-fpm                          RUNNING
# queue-worker                     RUNNING   (project-a)
# scheduler                        RUNNING   (project-a)
```

### Menambah Queue Worker untuk Project B (Opsional)

Edit `docker/php/supervisor.conf`, tambahkan:

```ini
[program:queue-worker-project-b]
directory=/var/www/html/project-b
command=php artisan queue:work database --sleep=1 --tries=3 --queue=default
autostart=true
autorestart=true
startsecs=5
stopasgroup=true
killasgroup=true
stdout_logfile=/dev/fd/1
stdout_logfile_maxbytes=0
stderr_logfile=/dev/fd/2
stderr_logfile_maxbytes=0
priority=25
```

Rebuild:

```zsh
docker compose build php && docker compose up -d
docker compose exec php supervisorctl reread
docker compose exec php supervisorctl update
```

### Test Queue

```zsh
# Buat job
docker compose exec php bash -c "cd /var/www/html/project-a && php artisan make:job TestJob"

# Dispatch via tinker
docker compose exec php bash -c "cd /var/www/html/project-a && php artisan tinker"
# > dispatch(new \App\Jobs\TestJob());

# Lihat logs queue worker
docker compose logs -f php | grep queue
```

---

## Troubleshooting

### Port 80 sudah digunakan

Ubah port di `docker/.env`:

```bash
NGINX_HTTP_PORT=8080
```

Lalu update `APP_URL` di `.env` proyek menjadi `http://project-a.local:8080`

### Redis/Memcached connection refused

Pastikan profile aktif:

```zsh
docker compose --profile redis --profile memcached up -d
docker compose ps
```

### Database connection refused

Tunggu MySQL selesai healthcheck:

```zsh
docker compose logs mysql
# Tungil "ready for connections"
```

### Permission denied di storage/

Jalankan fix permission (lihat section Commands Berguna)

---

## Stop & Cleanup

```zsh
# Stop semua container
docker compose down

# Stop + hapus volumes (HATI-HATI: data MySQL hilang)
docker compose down -v

# Rebuild dari awal
docker compose down -v
docker compose --profile redis --profile memcached up -d --build
```

---

## Tips

- Domain `*.local` memerlukan entry di `/etc/hosts`
- Untuk development lokal, gunakan `*.localhost` agar auto-resolve tanpa edit hosts
- Gunakan `docker compose exec php bash` untuk akses shell interaktif
- Supervisor logs tersedia via `docker compose logs php`
- MySQL data disimpan di Docker volume `mysql-data` (persistent)
- Semua container menggunakan platform `linux/amd64` untuk kompatibilitas penuh dengan Linux production

---

## Support

Untuk pertanyaan atau issue terkait setup Docker ini, silakan lihat:

- Docker Compose docs: <https://docs.docker.com/compose/>
- Laravel docs: <https://laravel.com/docs>
- Supervisor docs: <http://supervisord.org/>
