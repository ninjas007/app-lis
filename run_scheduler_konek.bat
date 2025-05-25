@echo off
title HL7 Multi-Listen Scheduler
cd /d "C:\laragon\www\app-lis"
set PATH=C:\laragon\bin\php\php-8.2.19-Win32-vs16-x64;%PATH%
echo Menjalankan HL7 Multi-Listen Scheduler...
:loop
php artisan schedule:hl7-multi-listen
timeout /t 15 >nul
goto loop
