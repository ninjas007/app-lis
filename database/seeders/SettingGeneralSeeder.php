<?php

namespace Database\Seeders;

use App\Models\SettingGeneral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingGeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key' => 'limit_connection',
                'value' => json_encode(['value' => 1, 'unit' => 'minute']), // 1,
            ],
        ];

        SettingGeneral::insert($data);
    }
}
