@echo off
title HL7 Process Scheduler
cd /d "C:\laragon\www\app-lis"
set PATH=C:\laragon\bin\php\php-8.2.19-Win32-vs16-x64;%PATH%
echo Menjalankan HL7 Process Scheduler...
:loop
php artisan hl7:process
timeout /t 15 >nul
goto loop
