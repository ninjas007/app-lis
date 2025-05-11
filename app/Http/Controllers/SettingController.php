<?php

namespace App\Http\Controllers;

use App\Models\SettingGeneral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    private $page = 'sistem';

    public function index()
    {
        return view('setting.index', [
            'page' => $this->page,
            'title' => 'Setting'
        ]);
    }

    public function general()
    {
        $settingGeneral = SettingGeneral::all();

        if ($settingGeneral) {
            $setting = $settingGeneral;
        } else {
            // running seeder
            Artisan::call('db:seed --class=SettingGeneralSeeder');
            $setting = SettingGeneral::first();
        }

        $setting = $setting->map(function ($item) {
            return [
                'key' => $item->key,
                'value' => json_decode($item->value)
            ];
        });

        return view('setting.general', [
            'page' => $this->page,
            'title' => 'Setting General',
            'setting' => $setting
        ]);
    }
}
