<?php

use App\Http\Controllers\HL7LabResultController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LabResultController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// kalau sudah login redirect ke dashboard
Route::get('/', function () {
    return redirect('/home');
})->middleware('auth');

Route::post('/login', [LoginController::class, 'store'])->name('login');

// route with auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // pasien
    Route::group(['prefix' => 'pasien'], function () {
        Route::get('/', [PasienController::class, 'index'])->name('patients.index');
        Route::get('/data', [PasienController::class, 'getData'])->name('patients.data');
        Route::get('/{uid}', [PasienController::class, 'show'])->name('patients.show');
        Route::get('/{uid}/lab', [PasienController::class, 'getDataResult'])->name('patients.getDataResult');
        Route::get('/{pasienUid}/detail/{resultUid}', [PasienController::class, 'detail'])->name('patients.detail');
    });

    // setting
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/', [SettingController::class, 'store'])->name('setting.store');
    });

    // tentang
    Route::group(['prefix' => 'tentang'], function () {
        Route::get('/', [AboutController::class, 'index'])->name('about.index');
    });

    // hasil
    Route::group(['prefix' => 'hasil'], function () {
        Route::get('/', [LabResultController::class, 'index'])->name('hasil.index');
        Route::get('/data', [LabResultController::class, 'getData'])->name('hasil.data');
    });
});

// Route::get('/hasil', [HL7LabResultController::class, 'index']);
