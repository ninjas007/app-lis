@echo off
title Laravel Scheduler & Queue Worker
cd /d "C:\laragon\www\app-lis"

REM File PHP
set PATH=C:\laragon\bin\php\php-8.2.19-Win32-vs16-x64;%PATH%

echo Menjalankan Laravel Scheduler dan Queue Worker...
echo Tekan CTRL + C untuk berhenti.

REM Menjalankan Queue Worker di background
start php artisan queue:work --daemon

REM Loop Scheduler
:loop
php artisan schedule:run
timeout /t 60 >nul
goto loop
