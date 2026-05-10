<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\C45Controller;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('penilaian', PenilaianController::class);
    Route::get('/hasil-klasifikasi', [PenilaianController::class, 'hasil'])->name('penilaian.hasil');
    Route::get('/ranking', [PenilaianController::class, 'ranking'])->name('penilaian.ranking');
    Route::get('/export-pdf', [PenilaianController::class, 'exportPdf'])->name('penilaian.export-pdf');

    Route::get('/c45', [C45Controller::class, 'index'])->name('c45.index');
    Route::get('/c45/proses', [C45Controller::class, 'proses'])->name('c45.proses');

    Route::middleware(['admin'])->group(function () {

        Route::resource('guru', GuruController::class);

        // ⚠️ Route spesifik HARUS sebelum resource
        Route::get('/students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
        Route::get('/students/import', [StudentController::class, 'importForm'])->name('students.import');
        Route::post('/students/import', [StudentController::class, 'import'])->name('students.import.post');
        Route::delete('/students/destroy-all', [StudentController::class, 'destroyAll'])->name('students.destroy-all');
        Route::delete('/students/destroy-selected', [StudentController::class, 'destroySelected'])->name('students.destroy-selected');

        // Resource PALING BAWAH
        Route::resource('students', StudentController::class);
    });

});