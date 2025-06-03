<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dosen\KelasController as DosenKelasController;
use App\Http\Controllers\Dosen\MahasiswaController as DosenMahasiswaController;
use App\Http\Controllers\Dosen\MateriController as DosenMateriController;

use App\Http\Controllers\Mahasiswa\KelasController as MahasiswaKelasController;
use App\Http\Controllers\Mahasiswa\MateriController as MahasiswaMateriController;
use App\Http\Controllers\Mahasiswa\ExamController as MahasiswaExamController;
use App\Http\Controllers\Mahasiswa\PretestController as MahasiswaPretestController;

use App\Http\Controllers\Umum\KelasController as UmumKelasController;
use App\Http\Controllers\Umum\MateriController as UmumMateriController;
use App\Http\Controllers\Umum\ExamController as UmumExamController;
use App\Http\Controllers\Umum\PretestController as UmumPretestController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\MatakuliahController as AdminMatakuliahController;
use App\Http\Controllers\Admin\KelasController as AdminKelasController;
use App\Http\Controllers\Admin\MateriController as AdminMateriController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\LanguageController;

Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'profileUpdate'])->name('profile.update');

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
        Route::put('/{kode_kelas}/update', [DosenKelasController::class, 'update'])->name('update');
        Route::post('/{kode_kelas}/delete', [DosenKelasController::class, 'delete'])->name('delete');

        Route::get('/{kode_kelas}', [DosenKelasController::class, 'show'])->name('show');

        Route::put('/nilai/{nim}', [DosenKelasController::class, 'updateNilai'])->name('updateNilai');

        Route::post('pretest/{kode_kelas}/create', [DosenKelasController::class, 'pretestCreate'])->name('pretestCreate');
        Route::get('pretest/{kode_kelas}/soal/create', [DosenKelasController::class, 'pretestQuestionCreate'])->name('pretestQuestionCreate');
        Route::post('pretest/{kode_kelas}/soal/store', [DosenKelasController::class, 'pretestQuestionStore'])->name('pretestQuestionStore');
        Route::get('pretest/{kode_kelas}/soal/edit/{question_id}', [DosenKelasController::class, 'pretestQuestionEdit'])->name('pretestQuestionEdit');
        Route::put('pretest/{kode_kelas}/soal/update/{question_id}', [DosenKelasController::class, 'pretestQuestionUpdate'])->name('pretestQuestionUpdate');
        Route::delete('pretest/{kode_kelas}/soal/delete/{question_id}', [DosenKelasController::class, 'pretestQuestionDelete'])->name('pretestQuestionDelete');

        Route::get('/{kode_kelas}/materi/{id}', [DosenMateriController::class, 'materi'])->name('materi.show');
        Route::get('/{kode_kelas}/materi/{id}/diskusi-pribadi/{chat_id?}', [DosenMateriController::class, 'materiDiskusiPribadi'])->name('materi.diskusiPribadi');

        //ujian
        Route::get('/{kode_kelas}/materi/{id}/soal-ujian', [DosenMateriController::class, 'ujianSoal'])->name('materi.ujianSoal');
        Route::post('/{kode_kelas}/materi/{id}/soal-ujian', [DosenMateriController::class, 'ujianSoalStore'])->name('materi.ujianSoal.store');
        Route::put('/{kode_kelas}/materi/{id}/soal-ujian', [DosenMateriController::class, 'ujianSoalUpdate'])->name('materi.ujianSoal.update');

        Route::get('/{kode_kelas}/materi/{id}/soal-ujian-create', [DosenMateriController::class, 'ujianSoalQuestionCreate'])->name('materi.ujianSoalQuestionCreate');
        Route::post('/{kode_kelas}/materi/{id}/soal-ujian-create', [DosenMateriController::class, 'ujianSoalQuestionStore'])->name('materi.ujianSoalQuestionStore');
        Route::get('/{kode_kelas}/materi/{id}/soal-ujian-edit/{question_id}', [DosenMateriController::class, 'ujianSoalQuestionEdit'])->name('materi.ujianSoalQuestionEdit');
        Route::put('/{kode_kelas}/materi/{id}/soal-ujian-edit/{question_id}', [DosenMateriController::class, 'ujianSoalQuestionUpdate'])->name('materi.ujianSoalQuestionUpdate');
        Route::delete('/{kode_kelas}/materi/{id}/soal-ujian-delete/{question_id}', [DosenMateriController::class, 'ujianSoalQuestionDelete'])->name('materi.ujianSoalQuestionDelete');

        Route::get('/{kode_kelas}/materi/{id}/nilai-ujian', [DosenMateriController::class, 'ujianNilai'])->name('materi.ujianNilai');

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

Route::post('/kirimDiskusiPribadDosen/{materi_id}/chat/{chat_id}', [DosenMateriController::class, 'kirimDiskusiPribadi'])->name('kirimDiskusiPribadiDosen');


Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->name('mahasiswa.')->group(function () {
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [MahasiswaKelasController::class, 'index'])->name('index');
        Route::post('/join', [MahasiswaKelasController::class, 'join'])->name('join');

        Route::get('/{kode_kelas}/pretest', [MahasiswaPretestController::class, 'pretest'])->name('pretest');
        Route::get('/pretest/api-soal', [MahasiswaPretestController::class, 'pretestSoal'])->name('pretestSoal');
        Route::post('/pretest/api-jawab', [MahasiswaPretestController::class, 'pretestJawab'])->name('pretestJawab');
        Route::post('/{kode_kelas}/pretest/selesai', [MahasiswaPretestController::class, 'pretestSelesai'])->name('pretestSelesai');

        Route::get('/{kode_kelas}', [MahasiswaKelasController::class, 'show'])->name('show');
        Route::get('/{kode_kelas}/materi/{id}', [MahasiswaMateriController::class, 'materi'])->name('materi');
        Route::get('/{kode_kelas}/materi/{id}/diskusi-pribadi', [MahasiswaMateriController::class, 'materiDiskusiPribadi'])->name('materiDiskusiPribadi');
        Route::get('/{kode_kelas}/materi/{id}/history-ujian', [MahasiswaMateriController::class, 'historyUjian'])->name('historyUjian');

        Route::get('/{kode_kelas}/materi/{id}/exam', [MahasiswaExamController::class, 'exam'])->name('exam');
        Route::get('/materi/exam-soal', [MahasiswaExamController::class, 'examSoal'])->name('examSoal');
        Route::post('/materi/exam-jawab', [MahasiswaExamController::class, 'examJawab'])->name('examJawab');
        Route::post('/{kode_kelas}/materi/{id}/exam/selesai', [MahasiswaExamController::class, 'examSelesai'])->name('examSelesai');


    });
});

Route::prefix('umum')->middleware(['auth', 'role:umum'])->name('umum.')->group(function () {
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [UmumKelasController::class, 'index'])->name('index');

        Route::get('/{kode_kelas}/pretest', [UmumPretestController::class, 'pretest'])->name('pretest');
        Route::get('/pretest/api-soal', [UmumPretestController::class, 'pretestSoal'])->name('pretestSoal');
        Route::post('/pretest/api-jawab', [UmumPretestController::class, 'pretestJawab'])->name('pretestJawab');
        Route::post('/{kode_kelas}/pretest/selesai', [UmumPretestController::class, 'pretestSelesai'])->name('pretestSelesai');

        Route::get('/{kode_kelas}', [UmumKelasController::class, 'show'])->name('show');
        Route::get('/{kode_kelas}/materi/{id}/history-ujian', [UmumMateriController::class, 'historyUjian'])->name('historyUjian');

        Route::get('/{kode_kelas}/materi/{id}/exam', [UmumExamController::class, 'exam'])->name('exam');
        Route::get('/materi/exam-soal', [UmumExamController::class, 'examSoal'])->name('examSoal');
        Route::post('/materi/exam-jawab', [UmumExamController::class, 'examJawab'])->name('examJawab');
        Route::post('/{kode_kelas}/materi/{id}/exam/selesai', [UmumExamController::class, 'examSelesai'])->name('examSelesai');


    });
});



Route::post('/kirimDiskusiGrup/{materi_id}', [MahasiswaMateriController::class, 'kirimDiskusiGrup'])->name('kirimDiskusiGrup');
Route::post('/kirimDiskusiPribadi/{materi_id}', [MahasiswaMateriController::class, 'kirimDiskusiPribadi'])->name('kirimDiskusiPribadi');
Route::post('/testKirimDiskusiPribadi/{materi_id}', [MahasiswaMateriController::class, 'testKirimDiskusiPribadi'])->name('testKirimDiskusiPribadi');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/stat', [AdminDashboardController::class, 'stat'])->name('stat');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/store', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [AdminUserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('matakuliah')->name('matakuliah.')->group(function () {
        Route::get('/', [AdminMatakuliahController::class, 'index'])->name('index');
        Route::post('/store', [AdminMatakuliahController::class, 'store'])->name('store');
        Route::put('/{id}/update', [AdminMatakuliahController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [AdminMatakuliahController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [AdminKelasController::class, 'index'])->name('index');
        Route::post('/store', [AdminKelasController::class, 'store'])->name('store');
        Route::put('/{id}/update', [AdminKelasController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [AdminKelasController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('materi')->name('materi.')->group(function () {
        Route::get('/', [AdminMateriController::class, 'index'])->name('index');
        Route::get('/show/{id}', [AdminMateriController::class, 'show'])->name('show');
        Route::delete('/{id}/destroy', [AdminMateriController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/website', [AdminSettingController::class, 'website'])->name('website');
        Route::put('/website', [AdminSettingController::class, 'websiteUpdate'])->name('website.update');
        Route::put('/website/info', [AdminSettingController::class, 'informationUpdate'])->name('website.info');
    });
});
