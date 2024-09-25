<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dosen\KelasController as DosenKelasController;
use App\Http\Controllers\Dosen\MahasiswaController as DosenMahasiswaController;
use App\Http\Controllers\Dosen\MateriController as DosenMateriController;

use App\Http\Controllers\Mahasiswa\KelasController as MahasiswaKelasController;
use App\Http\Controllers\Mahasiswa\MateriController as MahasiswaMateriController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

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

        Route::get('/{kode_kelas}/materi/{id}', [DosenMateriController::class, 'materi'])->name('materi.show');
        Route::get('/{kode_kelas}/materi/{id}/diskusi-grup', [DosenMateriController::class, 'materiDiskusiPribadi'])->name('materi.diskusiGrup');

        
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::post('/invite/{kode_kelas}', [DosenMahasiswaController::class, 'invite'])->name('invite');
        Route::put('/accept/{id}', [DosenMahasiswaController::class, 'accept'])->name('accept');
        Route::put('/reject/{id}', [DosenMahasiswaController::class, 'reject'])->name('reject');
        Route::delete('/kick/{id}', [DosenMahasiswaController::class, 'kick'])->name('kick');
    });



    Route::prefix('materi')->name('materi.')->group(function () {
        Route::get('/create/{kode_kelas}', [DosenMateriController::class, 'create'])->name('create');
        Route::post('/uploadFile', [DosenMateriController::class, 'uploadFile'])->name('uploadFile');
        Route::post('/store', [DosenMateriController::class, 'store'])->name('store');

        Route::get('/{id}', [DosenMateriController::class, 'show'])->name('show');
       
        
    });

});

Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->name('mahasiswa.')->group(function () {
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [MahasiswaKelasController::class, 'index'])->name('index');
        Route::get('/{kode_kelas}', [MahasiswaKelasController::class, 'show'])->name('show');
        Route::get('/{kode_kelas}/materi/{id}', [MahasiswaMateriController::class, 'materi'])->name('materi');
        Route::get('/{kode_kelas}/materi/{id}/diskusi-pribadi', [MahasiswaMateriController::class, 'materiDiskusiPribadi'])->name('materiDiskusiPribadi');


    });
});

Route::post('/kirimDiskusiGrup/{materi_id}', [MahasiswaMateriController::class, 'kirimDiskusiGrup'])->name('kirimDiskusiGrup');
Route::post('/kirimDiskusiPribadi/{materi_id}', [MahasiswaMateriController::class, 'kirimDiskusiPribadi'])->name('kirimDiskusiPribadi');
Route::post('/testKirimDiskusiPribadi/{materi_id}', [MahasiswaMateriController::class, 'testKirimDiskusiPribadi'])->name('testKirimDiskusiPribadi');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/store', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [AdminUserController::class, 'delete'])->name('delete');
    });
});