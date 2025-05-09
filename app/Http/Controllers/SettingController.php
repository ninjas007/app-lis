<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $page = 'sistem';

    public function index()
    {
        return view('setting.index', [
            'page' => $this->page,
            'title' => 'Pasien'
        ]);
    }
}
