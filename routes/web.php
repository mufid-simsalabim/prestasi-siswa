<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\C45Controller;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\RankingController;

/*
|--------------------------------------------------------------------------
| Landing Page (publik)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ranking Kelas (guru & admin)
    Route::get('/ranking-kelas', [RankingController::class, 'rankingKelas'])->name('ranking.kelas');

    /*
    |--------------------------------------------------------------------------
    | Khusus Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {

        // Data Siswa
        Route::get('/students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
        Route::get('/students/import', [StudentController::class, 'importForm'])->name('students.import');
        Route::post('/students/import', [StudentController::class, 'import'])->name('students.import.post');
        Route::delete('/students/destroy-all', [StudentController::class, 'destroyAll'])->name('students.destroy-all');
        Route::delete('/students/destroy-selected', [StudentController::class, 'destroySelected'])->name('students.destroy-selected');
        Route::resource('students', StudentController::class);

        // Kelola Guru
        Route::resource('guru', GuruController::class);

        // Mata Pelajaran
        Route::resource('mapel', MataPelajaranController::class);

        // Kelas
        Route::resource('kelas', KelasController::class);

        // Ranking Angkatan (hanya admin)
        Route::get('/ranking-angkatan', [RankingController::class, 'rankingAngkatan'])->name('ranking.angkatan');

        // Hasil Klasifikasi & Export PDF (admin)
        Route::get('/hasil-klasifikasi', [PenilaianController::class, 'hasil'])->name('penilaian.hasil');
        Route::get('/export-pdf', [PenilaianController::class, 'exportPdf'])->name('penilaian.export-pdf');

        // Proses C4.5 (admin)
        Route::get('/c45', [C45Controller::class, 'index'])->name('c45.index');
        Route::get('/c45/proses', [C45Controller::class, 'proses'])->name('c45.proses');
    });

    /*
    |--------------------------------------------------------------------------
    | Khusus Guru
    |--------------------------------------------------------------------------
    */
    Route::middleware(['guru'])->group(function () {

        // Penilaian
        Route::resource('penilaian', PenilaianController::class);

        // Hasil Klasifikasi (guru)
        Route::get('/hasil-prestasi', [PenilaianController::class, 'hasil'])->name('guru.hasil');

        // Raport
        Route::get('/raport', [RaportController::class, 'index'])->name('raport.index');
        Route::get('/raport/{student}/input', [RaportController::class, 'input'])->name('raport.input');
        Route::post('/raport/{student}/store', [RaportController::class, 'store'])->name('raport.store');
        Route::get('/raport/{student}/show', [RaportController::class, 'show'])->name('raport.show');
        Route::get('/raport/{student}/cetak', [RaportController::class, 'cetak'])->name('raport.cetak');
    });

});