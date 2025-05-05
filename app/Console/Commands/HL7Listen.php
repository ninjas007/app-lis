<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class HL7Listen extends Command
{
    protected $signature = 'hl7:listen';
    protected $description = 'Listen HL7 messages on TCP socket';

    public function handle()
    {
        $address = '0.0.0.0';
        $port = 5600;

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

            // Simpan ke file di storage/app/hl7/
            $timestamp = now()->format('Ymd_His_u');
            $filename = "hl7/{$timestamp}.hl7";

            Storage::disk('local')->put($filename, $hl7);
            $this->info("Saved to: storage/app/$filename");
        }

        fclose($socket);
    }

    protected function stripHL7Envelope($data)
    {
        return trim($data, "\x0b\x1c\r");
    }
}
