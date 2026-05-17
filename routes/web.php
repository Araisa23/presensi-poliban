<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\JadwalKerjaController;
use App\Http\Controllers\LokasiKantorController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // IMPORT EXCEL
        Route::get('users/import', [UserController::class, 'importForm'])
            ->name('users.import.form');

        Route::post('users/import', [UserController::class, 'import'])
            ->name('users.import');

        // USERS
        Route::resource('users', UserController::class);

        Route::post('pegawai/import', [PegawaiController::class, 'import']) 
        ->name('pegawai.import');

        Route::get(
            'pegawai/template/download',
            [PegawaiController::class, 'downloadTemplate']
        )->name('pegawai.template.download');

        Route::resource('pegawai', PegawaiController::class);
        Route::resource('unit-kerja', UnitKerjaController::class);
        Route::resource('jadwal-kerja', JadwalKerjaController::class);
        Route::resource('lokasi-kantor', LokasiKantorController::class);
        Route::resource('pengumuman', PengumumanController::class);

        Route::get('presensi', [PresensiController::class, 'index'])
            ->name('presensi.index');

        Route::delete('presensi/{presensi}', [PresensiController::class, 'destroy'])
            ->name('presensi.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PEGAWAI
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:pegawai')
        ->prefix('pegawai')
        ->name('pegawai.')
        ->group(function () {

            Route::get('presensi', [PresensiController::class, 'create'])
                ->name('presensi.create');

            Route::post('presensi', [PresensiController::class, 'store'])
                ->name('presensi.store');

            Route::get('riwayat', [PresensiController::class, 'history'])
                ->name('presensi.history');
        });

    /*
    |--------------------------------------------------------------------------
    | PIMPINAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:pimpinan')
        ->prefix('pimpinan')
        ->name('pimpinan.')
        ->group(function () {

            Route::get('monitoring', [LaporanController::class, 'monitoring'])
                ->name('monitoring');

            Route::get('laporan', [LaporanController::class, 'index'])
                ->name('laporan.index');

            Route::get('rekap', [LaporanController::class, 'rekap'])
                ->name('rekap');

            Route::get('rekap/excel', [LaporanController::class, 'exportExcel'])
                ->name('rekap.excel');

            Route::get('rekap/pdf', [LaporanController::class, 'exportPdf'])
                ->name('rekap.pdf');
        });

});

require __DIR__.'/auth.php';