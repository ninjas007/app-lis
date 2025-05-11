<?php

namespace App\Console\Commands;

use App\Models\LogAlatConnect;
use Illuminate\Console\Command;
use App\Models\SettingAlat;
use Symfony\Component\Process\Process;

class Hl7MultiListen extends Command
{
    protected $signature = 'hl7:multi-listen';
    protected $description = 'Listen to multiple HL7 connections on TCP sockets';

    public function handle()
    {
        $alatList = SettingAlat::where('status', 'active')->get();

        if ($alatList->isEmpty()) {
            $this->error('Tidak ada alat yang ditemukan di database.');
            return;
        }

        $this->info("Memulai proses listen untuk setiap alat...");

        foreach ($alatList as $alat) {
            $this->info("Starting listener for: {$alat->name} on {$alat->ip_address}:{$alat->port}");

            // Path folder berdasarkan nama alat
            $name = strtolower($alat->name);

            // Start listener process
            $process = new Process([
                'php',
                'artisan',
                'hl7:listen',
                $alat->ip_address,
                $alat->port,
                $alat->id,
                $name
            ]);

            $process->start();

            // Tunggu sampai process selesai
            $process->wait();

            $this->info("Listener for: {$alat->name} on {$alat->ip_address}:{$alat->port} selesai.");
        }

        $this->info("Proses listen selesai.");
    }
}
