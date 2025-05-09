<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    private $page = 'about';

    public function index()
    {
        return view('about.index', [
            'page' => $this->page,
            'title' => 'About'
        ]);
    }
}
