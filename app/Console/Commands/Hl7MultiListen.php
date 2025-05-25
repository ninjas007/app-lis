<?php

namespace App\Console\Commands;

use App\Models\SettingAlat;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Hl7MultiListen extends Command
{
    protected $signature = 'hl7:multi-listen';
    protected $description = 'Listen to multiple HL7 connections on TCP sockets';

    protected $processes = [];

    public function handle()
    {
        $alatList = SettingAlat::where('status', 'active')->get();

        if ($alatList->isEmpty()) {
            $this->error('Tidak ada alat yang ditemukan di database.');
            return;
        }

        $this->info("Memulai proses listen untuk setiap alat...");

        foreach ($alatList as $alat) {
            $this->info("Starting listener for: {$alat->name} on {$alat->ip_local}:{$alat->port}");

            $replaceSpace = str_replace(' ', '_', $alat->name);
            $name = strtolower($replaceSpace);

            $process = new Process([
                'php',
                'artisan',
                'hl7:listen',
                $alat->ip_local,
                $alat->port,
                $alat->id,
                $name
            ]);

            $process->start(); // Run asynchronously
            $this->processes[] = $process;
        }

        // Loop agar command utama tetap hidup
        while (true) {
            sleep(5); // Hindari konsumsi CPU berlebih
            // (Opsional) Bisa tambahkan logika monitoring process status di sini
        }
    }
}
