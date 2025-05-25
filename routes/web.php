<?php

use App\Http\Controllers\HL7LabResultController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\LabResultController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\Master\RuanganController;
use App\Http\Controllers\Master\StatusPasienController;
use App\Http\Controllers\Master\JenisLayananController;
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
    Route::get('/profile', [LoginController::class, 'profile'])->name('profile');
    Route::post('/profile', [LoginController::class, 'saveProfile'])->name('saveProfile');

    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    Route::middleware(['client'])->group(function () {
        // pasien
        Route::group(['prefix' => 'pasien'], function () {
            Route::get('/', [PasienController::class, 'index'])->name('patients.index');
            Route::get('/data', [PasienController::class, 'getData'])->name('patients.data');
            Route::get('/{uid}', [PasienController::class, 'show'])->name('patients.show');
            Route::get('/{uid}/lab', [PasienController::class, 'getDataResult'])->name('patients.getDataResult');
            Route::get('/{pasienUid}/detail/{resultUid}', [PasienController::class, 'detail'])->name('patients.detail');
            Route::post('/{pasienUid}/detail/{resultUid}', [PasienController::class, 'saveDetail'])->name('patients.saveDetail');
            Route::post('/{pasienUid}/hasil-pemeriksaan/{resultUid}', [PasienController::class, 'saveHasilPemeriksaan'])->name('patients.saveHasilPemeriksaan');
            Route::get('/{pasienUid}/print/{resultUid}', [PasienController::class, 'print'])->name('patients.print');
            // Route::get('/{pasienUid}/preview/{resultUid}', [PasienController::class, 'preview'])->name('patients.preview');
        });

        // setting
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [SettingController::class, 'index'])->name('setting.index');
            Route::get('/general', [SettingController::class, 'general'])->name('setting.general');
            Route::post('/general', [SettingController::class, 'saveGeneral'])->name('setting.saveGeneral');

            Route::group(['prefix' => 'alat'], function () {
                Route::get('/', [AlatController::class, 'index'])->name('setting.alat');
                Route::get('/create', [AlatController::class, 'create'])->name('setting.alat.create');
                Route::post('/store', [AlatController::class, 'store'])->name('setting.alat.store');
                Route::get('/{uid}/edit', [AlatController::class, 'edit'])->name('setting.alat.edit');
                Route::put('/{uid}/update', [AlatController::class, 'update'])->name('setting.alat.update');
                Route::delete('/{uid}/destroy', [AlatController::class, 'destroy'])->name('setting.alat.destroy');
            });
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

        // parameter
        Route::resource('parameter', ParameterController::class);

        // master
        Route::group(['prefix' => 'master'], function () {

            // ruangan
            Route::group(['prefix' => 'ruangan'], function () {
                Route::get('/', [RuanganController::class, 'index'])->name('master.ruangan.index');
                Route::get('/{uid}/edit', [RuanganController::class, 'edit'])->name('master.ruangan.data');
                Route::get('/create', [RuanganController::class, 'create'])->name('master.ruangan.create');
                Route::post('/store', [RuanganController::class, 'store'])->name('master.ruangan.store');
                Route::put('/{uid}/update', [RuanganController::class, 'update'])->name('master.ruangan.update');
                Route::delete('/{uid}/destroy', [RuanganController::class, 'destroy'])->name('master.ruangan.destroy');
            });

            // status pasien
            Route::group(['prefix' => 'status-pasien'], function () {
                Route::get('/', [StatusPasienController::class, 'index'])->name('master.status-pasien.index');
                Route::get('/{uid}/edit', [StatusPasienController::class, 'edit'])->name('master.status-pasien.data');
                Route::get('/create', [StatusPasienController::class, 'create'])->name('master.status-pasien.create');
                Route::post('/store', [StatusPasienController::class, 'store'])->name('master.status-pasien.store');
                Route::put('/{uid}/update', [StatusPasienController::class, 'update'])->name('master.status-pasien.update');
                Route::delete('/{uid}/destroy', [StatusPasienController::class, 'destroy'])->name('master.status-pasien.destroy');
            });

            // jenis layanan
            Route::group(['prefix' => 'jenis-layanan'], function () {
                Route::get('/', [JenisLayananController::class, 'index'])->name('master.jenis-layanan.index');
                Route::get('/{uid}/edit', [JenisLayananController::class, 'edit'])->name('master.jenis-layanan.data');
                Route::get('/create', [JenisLayananController::class, 'create'])->name('master.jenis-layanan.create');
                Route::post('/store', [JenisLayananController::class, 'store'])->name('master.jenis-layanan.store');
                Route::put('/{uid}/update', [JenisLayananController::class, 'update'])->name('master.jenis-layanan.update');
                Route::delete('/{uid}/destroy', [JenisLayananController::class, 'destroy'])->name('master.jenis-layanan.destroy');
            });
        });
    });
});

// Route::get('/hasil', [HL7LabResultController::class, 'index']);
