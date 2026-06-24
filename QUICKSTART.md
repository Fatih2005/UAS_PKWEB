# Quick Start - Vulnerable App

## Jalankan di Windows/PowerShell atau bash

```powershell
cd "C:\downloads\Document\PKWEB\tugas 9"

php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

Buka http://localhost:8000

## Catatan
- Aplikasi ini disusun khusus untuk pembelajaran keamanan web.
- Jangan jalankan di lingkungan produksi.
- Untuk起诉 Anda bisa mencek README.md utama untuk panduan penggunaan.
