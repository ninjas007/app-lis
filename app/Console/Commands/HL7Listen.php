<?php

namespace App\Console\Commands;

use App\Models\SettingAlat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Hl7Listen extends Command
{
    protected $signature = 'hl7:listen {ip} {port} {id} {name}';
    protected $description = 'Listen HL7 messages on TCP socket';

    public function handle()
    {
        $address = $this->argument('ip');
        $port = $this->argument('port');
        $name = $this->argument('name');
        $id = $this->argument('id');

        $this->info("Starting listener for: $name on $address:$port");

        // Cek folder hl7
        if (!Storage::disk('local')->exists('hl7')) {
            Storage::disk('local')->makeDirectory('hl7');
            $this->call('storage:link');
            $this->info('Folder "hl7" created and storage linked.');
        }

        // Buat socket server
        try {
            $socket = stream_socket_server("tcp://$address:$port", $errno, $errstr);

            if (!$socket) {
                $this->error("Socket error: $errstr ($errno)");
                return;
            }

            $this->info("Listening on $address:$port...");

            while ($conn = @stream_socket_accept($socket, -1)) {
                if ($conn) {
                    $clientInfo = stream_socket_get_name($conn, true);
                    $this->info("Connected to: $clientInfo");

                    stream_set_timeout($conn, 5); // Timeout 5 detik

                    // Baca data dari client
                    $data = stream_get_contents($conn);

                    if ($data) {
                        $hl7 = $this->stripHL7Envelope($data);
                        $this->info("Received HL7 message:\n" . $hl7);

                        // Simpan file
                        $timestamp = now()->format('Ymd_His_u');
                        $filename = "hl7/{$name}_{$timestamp}.hl7";
                        Storage::disk('local')->put($filename, $hl7);

                        $this->info("Saved to: storage/app/$filename");

                        // Update last connected
                        $alat = SettingAlat::find($id);
                        if ($alat) {
                            $alat->last_connected_at = now();
                            $alat->save();
                            $this->info("Database updated for: $name");
                        }
                    } else {
                        $this->warn("Connection from $clientInfo was closed without data.");
                    }

                    fclose($conn);
                    $this->info("Connection closed: $clientInfo");
                }
            }

            fclose($socket);
        } catch (\Throwable $th) {
            Log::error("HL7 Listener Error: " . $th->getMessage());
            $this->error("HL7 Listener Error: " . $th->getMessage());
        }
    }

    protected function stripHL7Envelope($data)
    {
        // Bersihkan karakter header/trailer dari HL7
        return preg_replace('/^\x0b|\x1c\x0d$/', '', $data);
    }
}
