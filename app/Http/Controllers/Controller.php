<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function logError($e) {
        if (config('app.debug')) {
            dd($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
        }
        Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
    }
}
