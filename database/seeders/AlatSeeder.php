<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'uid' => Str::uuid(),
            'name' => 'Alat 1',
            'ip_address' => '127.0.0.1',
            'port' => 8080,
            'status' => 'active',
            'auto_connect' => 1
        ];
    }
}
