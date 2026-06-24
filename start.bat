@echo off
echo Stopping any old PHP servers...
taskkill //IM php.exe //F 2>nul
timeout /t 1 /nobreak >nul
echo.
echo Starting Laravel dev server at http://127.0.0.1:8000
php artisan serve --host=127.0.0.1 --port=8000
pause
