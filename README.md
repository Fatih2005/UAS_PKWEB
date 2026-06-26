# Sistem Ticketing Helpdesk PT. Ujug-Ujug
## Mata Kuliah: Pemrograman Keamanan Web (PKWEB) - UAS

Aplikasi helpdesk berbasis web untuk mengelola siklus hidup tiket secara terstruktur: pembuatan, penanganan, dan resolusi. Sistem ini mencakup autentikasi, otorisasi berbasis peran, manajemen kategori dan SLA, serta upload lampiran privat.

## Tech Stack

- **Backend**: Laravel 13 (PHP 8.5+)
- **Frontend**: Blade + Tailwind CSS + Font Awesome 6
- **Database**: SQLite (`database/database.sqlite`)
- **Authentication**: Session-based + bcrypt

## Fitur

### Public
- Registrasi & Login
- Reset Password berbasis token
- Logout

### User (Pemegang Tiket)
- Daftar tiket (miliknya / yang ditugaskan)
- Buat tiket + upload lampiran privat
- Detail tiket + komentar
- Edit/delete tiket saat status `open`
- Hapus komentar milik sendiri

### Admin
- Manajemen kategori tiket (CRUD + SLA)
- Assign petugas, ubah status/prioritas tiket
- Lihat seluruh tiket pengguna lain
- Edit/hapus komentar pengguna lain

## Keamanan

| OWASP | Mitigasi |
|-------|----------|
| Broken Access Control | `canBeManagedBy()` + `AdminMiddleware` + abort 403 |
| Cryptographic Failures | Password hash bcrypt (`Hash::make`/`Hash::check`) |
| Injection | Eloquent ORM / Query Builder, tanpa raw concatenation |
| Insecure Design | Token reset acak 60 char + base64 URL-safe encoding |
| Security Misconfiguration | CSRF token, attachment disk `private`, session regenerate |

## Instalasi

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Buka `http://127.0.0.1:8000`

## Struktur Database

| Tabel | Fungsi |
|-------|--------|
| `users` | Akun user/admin (`is_admin`) |
| `ticket_categories` | Kategori + SLA |
| `tickets` | Tiket utama + lampiran + status + prioritas |
| `ticket_comments` | Diskusi pada tiket |
| `password_reset_tokens` | Token reset password |


