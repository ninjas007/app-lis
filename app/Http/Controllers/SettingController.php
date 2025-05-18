<?php

namespace App\Http\Controllers;

use App\Models\SettingGeneral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\Facades\Image;

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

    public function general(Request $request)
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

    public function saveGeneral(Request $request)
    {
        try {
            if ($request->has('logo')) {
                $this->saveLogo($request);
            }

            if ($request->has('background')) {
                $this->saveBackground($request);
            }

            if ($request->has('gambar')) {
                $this->saveGambarLogin($request);
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            $this->logError($e);

            return redirect()->back()->with('error', 'Data gagal disimpan.');
        }
    }

    private function saveLogo($request)
    {
        $this->validate($request, [
            'logo' => 'image|mimes:png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo->move(public_path('images'), 'logo.png');
        }
    }

    private function saveBackground($request)
    {
        $this->validate($request, [
            'background' => 'image|mimes:png|max:2048',
        ]);

        if ($request->hasFile('background')) {
            $background = $request->file('background');
            $background->move(public_path('images'), 'background.png');
        }
    }

    private function saveGambarLogin($request)
    {
        $this->validate($request, [
            'gambar' => 'image|mimes:png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambar->move(public_path('images'), 'gambar-login.png');
        }
    }
}
