<?php

namespace Database\Seeders;

use App\Models\Master\MasterStatusPasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterStatusPasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uid' => Str::uuid(),
                'name' => 'Umum',
                'description' => ''
            ],
            [
                'uid' => Str::uuid(),
                'name' => 'BPJS',
                'description' => ''
            ],
        ];

        MasterStatusPasien::insert($data);
    }
}
