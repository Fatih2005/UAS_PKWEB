# Laravel Vulnerable Web App - Guestbook + Todo List
## Mata Kuliah: Pemrograman Keamanan Web

## Setup
1. `composer create-project laravel/laravel:^11.0 vulnerable-app`
2. Copy file di bawah ke struktur Laravel yang sesuai.
3. `composer require spatie/laravel-activitylog` (opsional, untuk audit log demo)
4. `php artisan migrate`
5. `php artisan serve`

## Vulnerability Matrix
| ID | Lokasi | Jenis |
|----|--------|-------|
| V1 | `routes/web.php` | CSRF bypass (guestbook routes) |
| V2 | `resources/views/guestbook/index.blade.php` | Stored XSS |
| V3 | `app/Http/Controllers/GuestbookController.php` | SQL Injection (search) |
| V4 | `app/Models/Todo.php` | Mass Assignment |
| V5 | `app/Http/Controllers/TodoController.php` | IDOR (show/destroy tanpa ownership check) |
| V6 | `app/Http/Controllers/TodoController.php:upload` | Insecure File Upload (original filename, no MIME check) |
| V7 | `app/Http/Controllers/AuthController.php` | Session Fixation (tidak regenerate ID) |
| V8 | `app/Http/Controllers/AuthController.php` | Weak Crypto (md5 password hashing) |

## Cara Test (Manual)
### V1 CSRF Bypass
Buat HTML di luar browser: `<form action="http://localhost:8000/guestbook/1" method="POST"><input name="_method" value="DELETE"><button>Delete</button></form>` => guestbook record terhapus tanpa token.

### V2 Stored XSS
Posting guestbook dengan message: `<script>alert('xss')</script>` => alert muncul di halaman index.

### V3 SQL Injection
Akses: `/guestbook/search?q=' OR 1=1 --` => semua record keluar.

### V4 Mass Assignment
POST `/todo` dengan body `title=exploit&is_admin=1` => kolom is_admin terisi (jika kolom ada di tabel).

### V5 IDOR
Login sebagai user A, buat todo ID 5. Login sebagai user B, akses `/todo/5` => user B bisa melihat/menghapus todo milik user A.

### V6 Insecure Upload
Tidak berlaku lagi pada project ini. Lampiran sekarang disimpan pada disk `private` dengan nama berkas acak (`uniqid().ext`), sehingga tidak dapat diakses langsung lewat URL publik.

### V7 Session Fixation
Set session ID manual sebelum login, setelah login session ID tetap sama.

### V8 Weak Crypto
Register dengan password `password123`, lalu cek di database (`users.password`) => hash md5 plain text.

## Remediation (untuk laporan)
- V1: hapus dari except array pada VerifyCsrfToken
- V2: gunakan `{{ $entry->message }}`, atau strip_tags/DOMPurify
- V3: gunakan parameter binding: `where('name', 'like', "%$search%")`
- V4: definisikan `$fillable` di model
- V5: tambahkan middleware auth + ownership check `$todo->user_id === auth()->id()`
- V6: validasi MIME type, generate random filename, simpan di luar webroot
- V7: `$request->session()->regenerate();` setelah login
- V8: pakai `Hash::make()` dan `Hash::check()` (bcrypt/default)
"# UAS-PKWEB" 
