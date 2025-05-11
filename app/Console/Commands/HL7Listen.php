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

        try {
            $socket = stream_socket_server("tcp://$address:$port", $errno, $errstr);

            if (!$socket) {
                $this->error("Socket error: $errstr ($errno)");
                return;
            }

            $this->info("Listening on $address:$port...");

            while ($conn = stream_socket_accept($socket)) {
                $data = '';
                while (!feof($conn)) {
                    $data .= fread($conn, 1024);
                }

                fclose($conn);

                $hl7 = $this->stripHL7Envelope($data);
                $this->info("Received HL7:\n" . $hl7);

                // create folder if not exist
                if (!Storage::disk('local')->exists('hl7')) {
                    Storage::disk('local')->makeDirectory('hl7');

                    // php artisan storage:link
                    $this->call('storage:link');

                    // change permission using chmod
                    chmod(storage_path('app/hl7'), 0777);
                }

                // Simpan ke file di folder sesuai nama alat
                $timestamp = now()->format('Ymd_His_u');
                $filename = "hl7/" . $name . "_" . $timestamp . ".hl7";

                Storage::disk('local')->put($filename, $hl7);
                $this->info("Saved to: storage/app/$filename");

                $alat = SettingAlat::find($this->argument('id'));
                $alat->last_connected_at = now();
                $alat->save();
            }

            fclose($socket);
        } catch (\Throwable $th) {
            Log::error($th);
            return;
        }
    }

    protected function stripHL7Envelope($data)
    {
        return trim($data, "\x0b\x1c\r");
    }
}
