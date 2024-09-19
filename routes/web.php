<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dosen\KelasController as DosenKelasController;
use App\Http\Controllers\Dosen\MahasiswaController as DosenMahasiswaController;
use App\Http\Controllers\Dosen\MateriController as DosenMateriController;

use App\Http\Controllers\Mahasiswa\KelasController as MahasiswaKelasController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::post('forgot-password', [AuthController::class, 'forgotPasswordProcess'])->name('forgot.password.process');
Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('reset-password/{token}', [AuthController::class, 'resetPasswordProcess'])->name('reset.password.process');

Route::prefix('dosen')->middleware(['auth', 'role:dosen'])->name('dosen.')->group(function () {
    
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [DosenKelasController::class, 'index'])->name('index');
        Route::post('/store', [DosenKelasController::class, 'store'])->name('store');
        Route::get('/{kode_kelas}/update', [DosenKelasController::class, 'update'])->name('update');
        Route::post('/{kode_kelas}/delete', [DosenKelasController::class, 'delete'])->name('delete');

        Route::get('/{kode_kelas}', [DosenKelasController::class, 'show'])->name('show');

        Route::put('/nilai/{nim}', [DosenKelasController::class, 'updateNilai'])->name('updateNilai');
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::post('/invite/{kode_kelas}', [DosenMahasiswaController::class, 'invite'])->name('invite');
        Route::delete('/kick/{id}', [DosenMahasiswaController::class, 'kick'])->name('kick');
    });



    Route::prefix('materi')->name('materi.')->group(function () {
        Route::get('/create/{kode_kelas}', [DosenMateriController::class, 'create'])->name('create');
        Route::post('/uploadFile', [DosenMateriController::class, 'uploadFile'])->name('uploadFile');
        Route::post('/store', [DosenMateriController::class, 'store'])->name('store');
    });

});

Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->name('mahasiswa.')->group(function () {
    Route::get('/kelas', [MahasiswaKelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/{kode_kelas}', [MahasiswaKelasController::class, 'show'])->name('kelas.show');
    Route::get('/materi/{kode_kelas}/{id}', [MahasiswaKelasController::class, 'materi'])->name('materi');
});


