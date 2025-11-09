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
---

<!-- _class: lead -->
# Laravel Advanced Features & Best Practices

## Workshop Hari 2: Implementasi Production-Ready

![bg right:40% 80%](https://laravel.com/img/logomark.min.svg)

---

<!-- _class: content -->
## Review Konsep Dasar

- Filosofi & Struktur Laravel
- Blade Templating Engine
- Model & Eloquent ORM
- Environment Management
- Deployment Best Practices

---

<!-- _class: content -->
## Rangkaian Materi Hari Ini

1. 🔧 **Artisan CLI & Automation**
   - Custom commands
   - Task scheduling
   - Maintenance tools

2. 🗃️ **Database Evolution**
   - Migration system
   - Seeding & factories
   - Schema versioning

3. 🛡️ **Security & Middleware**
   - Custom middleware
   - Request filtering
   - Authentication layers

---

<!-- _class: content -->
## Rangkaian Materi (Lanjutan)

1. 🌐 **API Development**
   - Sanctum setup
   - Token authentication
   - RESTful endpoints

2. 📈 **Maintenance & Upgrades**
   - Version management
   - Breaking changes
   - Update strategies

---

<!-- _class: content -->
## Artisan Command Development

```php
class SyncUsersCommand extends Command
{
    protected $signature = 'users:sync';
    protected $description = 'Synchronize user data';

    public function handle()
    {
        $this->info('Starting sync...');
        // Implementation
        $this->info('Users synced successfully!');
    }
}
```

---

<!-- _class: content -->
## Database Migration Pattern

```php
class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
```

---

<!-- _class: content -->
## Middleware Implementation

```php
class ApiAuthMiddleware
{
    public function handle($request, $next)
    {
        if (!$this->isValidToken($request)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }
        return $next($request);
    }
}
```

---

<!-- _class: content -->
## Sanctum API Authentication

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('products', ProductController::class);
});
```

---

<!-- _class: content -->
## Upgrade Strategy

### Version Management

- Follow LTS releases
- Test in staging
- Automated testing
- Gradual updates

### Security Best Practices

- HTTPS enforcement
- Input validation
- Rate limiting
- Regular updates

---

<!-- _class: lead -->
## Key Takeaways

1. Automation saves time
2. Database versioning is crucial
3. Security is multi-layered
4. APIs need proper authentication
5. Regular updates prevent technical debt

![bg right:30% 80%](https://laravel.com/img/logomark.min.svg)
