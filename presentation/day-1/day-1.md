---
marp: true
theme: default
class: invert
paginate: true
size: 16:9
style: |
  /* Base styling untuk slide */
  section {
    background-color: #1a1a1a !important;
    color: #ffffff;
    display: grid;
    grid-template-columns: 120px 1fr 120px;  /* Margin kiri & kanan 120px */
    font-size: 24px;
    padding: 20px 0;  /* Vertical padding */
  }

  /* Kontainer utama untuk konten */
  section > *:not([data-marpit-advanced-background-container]) {
    grid-column: 2;  /* Menempatkan konten di kolom tengah */
  }

  /* Background elements tetap full width */
  section > [data-marpit-advanced-background-container] {
    grid-column: 1 / -1;  /* Membentang seluruh grid */
  }

  /* Typography */
  h1 {
    font-size: 2.4em;
    color: #ffffff;
    margin-bottom: 0.5em;
  }

  h2 {
    font-size: 1.9em;
    color: #60a5fa;
    margin-bottom: 0.8em;
    border-bottom: 2px solid #60a5fa;
    padding-bottom: 0.2em;
  }

  h3 {
    font-size: 1.5em;
    color: #60a5fa;
    margin: 0.8em 0 0.4em;
  }

  /* Lists */
  ul, ol {
    padding-left: 1.5em;
    margin: 0.8em 0;
  }

  li {
    margin: 0.4em 0;
    line-height: 1.4;
  }

  /* Code blocks */
  pre {
    background: #2d2d2d;
    border-radius: 8px;
    padding: 1.2em;
    margin: 1em 0;
    font-size: 0.9em;
    overflow-x: auto;
    max-height: 400px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  /* Tables */
  table {
    border-collapse: collapse;
    margin: 1em 0;
    width: 100%;
  }

  th, td {
    border: 1px solid #444;
    padding: 0.8em;
  }

  th {
    background: #2d2d2d;
    color: #60a5fa;
  }

  /* Inline code */
  code {
    background: #2d2d2d;
    padding: 0.2em 0.4em;
    border-radius: 4px;
  }

  /* Images */
  img:not([data-marp-twemoji]) {
    max-height: 500px;
    object-fit: contain;
  }

  /* Two Column Layout */
  section.split {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
    padding: 20px 120px;
  }

  section.split > * {
    margin: 0;
  }

  section.split .left,
  section.split .right {
    background: rgba(45,45,45,0.5);
    padding: 20px;
    border-radius: 8px;
  }

  section.split h3 {
    margin-top: 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #60a5fa;
  }

  section.split ul {
    padding-left: 1em;
  }

  section.split li {
    margin-bottom: 15px;
  }

  section.split strong {
    display: block;
    color: #60a5fa;
    margin-bottom: 5px;
  }

  /* Typography */
  h1 {
    font-size: 2.4em;
    color: #ffffff;
    margin-bottom: 0.5em;
  }

  h2 {
    font-size: 1.9em;
    color: #60a5fa;
    margin-bottom: 0.8em;
    border-bottom: 2px solid #60a5fa;
    padding-bottom: 0.2em;
  }

  h3 {
    font-size: 1.5em;
    color: #60a5fa;
    margin: 0.8em 0 0.4em;
  }

  p, li {
    font-size: 1.1em;
    line-height: 1.5;
  }

  /* Lists */
  ul, ol {
    padding-left: 1.5em;
    margin: 0.8em 0;
  }

  li {
    margin: 0.4em 0;
  }

  /* Code blocks */
  pre {
    background: #2d2d2d;
    padding: 1.2em;
    margin: 1em auto;
    border-radius: 8px;
    font-size: 0.9em;
    overflow: auto;
    max-height: 400px;
    width: 90%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  /* Inline code */
  code {
    background: #2d2d2d;
    padding: 0.2em 0.4em;
    border-radius: 4px;
    color: #e0e0e0;
  }

  /* Tables */
  table {
    width: 90%;
    margin: 1em auto;
    border-collapse: collapse;
    background: #2d2d2d;
    color: #e0e0e0;
  }

  th, td {
    border: 1px solid #444;
    padding: 0.8em;
  }

  th {
    background: #1a1a1a;
    color: #60a5fa;
  }

  td {
    background: #2d2d2d;
  }

  /* Emphasis */
  strong {
    color: #60a5fa;
  }

  /* Images */
  img {
    max-height: 500px;
    object-fit: contain;
  }
---

<!-- _class: lead -->
# Migrasi dari CodeIgniter ke Laravel

## Fondasi & Konsep Dasar

### Membangun Aplikasi Modern dengan Laravel

![bg right:40% 80%](https://laravel.com/img/logomark.min.svg)

---

<!-- _class: content -->
## Tujuan Pembelajaran

- Memahami filosofi dan struktur Laravel
- Menguasai konsep MVC modern
- Implementasi fitur-fitur utama Laravel
- Pengelolaan environment development

---

<!-- _class: content -->
## Rangkaian Materi

1. 🏗️ **Struktur & Filosofi Laravel**
   - MVC Pattern Laravel
   - Service Container
   - Dependency Injection

2. 🎨 **Template Engine**
   - Blade Templating
   - Layout & Components
   - Reusable Views

3. 🔗 **Model & Database**
   - Eloquent ORM
   - Relationships
   - Query Builder

---

## Perbedaan Filosofi

### CodeIgniter 4 🔵

🎯 **Arsitektur**

- Minimalis & Fleksibel
- Ringan dan cepat
- Mudah dipelajari

🔧 **Dependency Injection**

- Manual & Eksplisit
- Kontrol penuh
- Sederhana

📊 **Database**

- Query Builder
- Performa tinggi
- SQL Native support

### Laravel 🟣

🏗️ **Arsitektur**

- Terstruktur dengan aturan baku
- Fitur lengkap & terintegrasi
- Ekosistem matang & luas

🎯 **Dependency Injection**

- Service Container
- Auto-resolution
- IoC Pattern

💾 **Database**

- Eloquent ORM
- Active Record
- Schema Builder---

<!-- _class: content -->
## Blade Templating System

```blade
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome, {{ $user->name }}</h1>

        @foreach($posts as $post)
            @include('components.post-card', ['post' => $post])
        @endforeach
    </div>
@endsection
```

---

<!-- _class: content -->
## Eloquent ORM & Relations

```php
class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

// Query Examples
$users = User::with('posts')
    ->where('active', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

---

<!-- _class: content -->
## Environment Management

```env
# .env.development
APP_NAME=MyApp
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1

# .env.production
APP_NAME=MyApp
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=production-db
```

---

<!-- _class: content -->
## Service Container & DI

```php
class UserService
{
    public function __construct(
        private Repository $repository,
        private Mailer $mailer
    ) {}

    public function register(array $data)
    {
        $user = $this->repository->create($data);
        $this->mailer->sendWelcome($user);
        return $user;
    }
}
```

---

<!-- _class: content -->
## PHP Standards Recommendations (PSR)

### Apa itu PSR? 🤔

- Standar penulisan kode PHP yang disepakati komunitas
- Dibuat oleh PHP-FIG (Framework Interop Group)
- Digunakan oleh framework modern termasuk Laravel

### PSR yang Sering Digunakan di Laravel

1. **PSR-4: Autoloading**
   - Struktur folder & namespace yang standar
   - Contoh: `App\Models\User`

2. **PSR-12: Coding Style**
   - Aturan penulisan kode
   - Indentasi, spasi, kurung

3. **PSR-7: HTTP Message**
   - Standar untuk request/response
   - Digunakan di API

---

<!-- _class: content -->
## Best Practices

### Struktur Aplikasi

- Gunakan service layer untuk logika bisnis
- Pisahkan kode berdasarkan fungsi
- Manfaatkan helpers untuk fungsi umum

### Organisasi Kode

- Ikuti standar PSR untuk konsistensi
- Gunakan type hinting untuk keamanan
- Dokumentasikan kode dengan baik

---

<!-- _class: lead -->
## Poin-Poin Penting

1. 🏗️ **Struktur Laravel** - Framework dengan aturan baku memudahkan pengembangan tim
2. 🎨 **Blade Template** - Pembuatan tampilan lebih terstruktur dengan komponen yang bisa digunakan ulang
3. 💾 **Eloquent ORM** - Pengelolaan database lebih mudah dengan syntax yang intuitif
4. ⚙️ **Environment** - Pemisahan konfigurasi development dan production sangat penting
5. 📝 **Standar Kode** - Mengikuti standar penulisan kode memudahkan maintenance jangka panjang

![bg right:30% 80%](https://laravel.com/img/logomark.min.svg)
