<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\UsersController;
use App\Models\Guru;
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

// protected page
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::prefix('account')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::post('/change-profile-picture', [AccountController::class, 'changeProfilePicture'])->name('account.change-profile-picture');
    });

    Route::prefix('settings')->group(function () {
        Route::post('/change_password', [AccountController::class, 'changePassword'])->name('settings.change_password');
        Route::get('/change_password', function () {
            return view('settings.change_password.index');
        })->name('settings.change_password');
        Route::post('/change_email', [AccountController::class, 'changeEmail'])->name('settings.change_email');
        Route::get('/change_email', function () {
            return view('settings.change_email.index');
        })->name('settings.change_email');
    });

    // only admin
    Route::group(['middleware' => ['onlyadmin']], function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UsersController::class, 'index'])->name('users');
            Route::post('/update/{id}', [UsersController::class, 'update'])->name('users.update');
            Route::post('/destroy/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
            Route::post('/store', [UsersController::class, 'store'])->name('users.store');
            Route::get('/reset_password/{id}', [AccountController::class, 'resetPassword'])->name('users.reset_password');
        });

        Route::prefix('siswa')->group(function () {
            Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
            Route::post('/store', [SiswaController::class, 'store'])->name('siswa.store');
            Route::post('/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
            Route::post('/destroy/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        });

        Route::prefix('guru')->group(function () {
            Route::get('/', [GuruController::class, 'index'])->name('guru.index');
            Route::post('/store', [GuruController::class, 'store'])->name('guru.store');
            Route::post('/update/{id}', [GuruController::class, 'update'])->name('guru.update');
            Route::post('/destroy/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');
        });

        Route::prefix('kelas')->group(function () {
            Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
            Route::post('/store', [KelasController::class, 'store'])->name('kelas.store');
            Route::post('/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
            Route::post('/destroy/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
            Route::post('/addSiswa/{id}', [KelasController::class, 'addSiswa'])->name('kelas.addSiswa');
            Route::get('/deleteSiswa/{id}', [KelasController::class, 'deleteSiswa'])->name('kelas.deleteSiswa');
        });

        Route::prefix('mapel')->group(function () {
            Route::get('/', [MapelController::class, 'index'])->name('mapel.index');
            Route::post('/store', [MapelController::class, 'store'])->name('mapel.store');
            Route::post('/update/{id}', [MapelController::class, 'update'])->name('mapel.update');
            Route::post('/destroy/{id}', [MapelController::class, 'destroy'])->name('mapel.destroy');
        });

        Route::prefix('jadwal')->group(function () {
            Route::get('/', [JadwalController::class, 'index'])->name('jadwal.index');
            Route::post('/store', [JadwalController::class, 'store'])->name('jadwal.store');
            Route::post('/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
            Route::post('/destroy/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
        });

        Route::prefix('semester')->group(function () {
            Route::get('/', [SemesterController::class, 'index'])->name('semester.index');
            Route::post('/store', [SemesterController::class, 'store'])->name('semester.store');
            Route::post('/update/{id}', [SemesterController::class, 'update'])->name('semester.update');
            Route::post('/destroy/{id}', [SemesterController::class, 'destroy'])->name('semester.destroy');
        });

        Route::prefix('tahun_akademik')->group(function () {
            Route::get('/', [TahunAkademikController::class, 'index'])->name('tahun_akademik.index');
            Route::post('/store', [TahunAkademikController::class, 'store'])->name('tahun_akademik.store');
            Route::post('/update/{id}', [TahunAkademikController::class, 'update'])->name('tahun_akademik.update');
            Route::post('/destroy/{id}', [TahunAkademikController::class, 'destroy'])->name('tahun_akademik.destroy');
        });

        Route::prefix('absensi')->group(function () {
            Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
            Route::post('/store', [AbsensiController::class, 'store'])->name('absensi.store');
            Route::post('/update/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
            Route::post('/destroy/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
            Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
            Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });

        Route::prefix('posts')->group(function () {
            Route::get('/', [PostsController::class, 'index'])->name('posts.index');
            Route::post('/store', [PostsController::class, 'store'])->name('posts.store');
            Route::post('/update/{id}', [PostsController::class, 'update'])->name('posts.update');
            Route::post('/destroy/{id}', [PostsController::class, 'destroy'])->name('posts.destroy');
        });

        Route::prefix('sekolah')->group(function () {
            Route::get('/logo', [SekolahController::class, 'changeLogo'])->name('sekolah.logo');
            Route::post('/update-logo', [SekolahController::class, 'storeLogo'])->name('sekolah.update-logo');
            Route::get('/profile', [SekolahController::class, 'profileSekolah'])->name('sekolah.profile');
            Route::post('/update-profile', [SekolahController::class, 'updateProfile'])->name('sekolah.update-profile');
        });
    });

    // only siswa
    Route::group(['middleware' => ['onlysiswa']], function () {
        Route::post('/siswa/profile', [SiswaController::class, 'updateMyBiodata'])->name('siswa.profile');
        Route::get('/account/kelas', [SiswaController::class, 'siswaKelas'])->name('siswa.kelas');
        Route::get('/jadwal/siswa', [JadwalController::class, 'jadwalSiswa'])->name('siswa.jadwal');
    });

    // only guru
    Route::group(['middleware' => ['onlyguru']], function () {
        Route::post('/guru/profile', [GuruController::class, 'updateMyBiodata'])->name('guru.profile');
        Route::get('/jadwal/guru', [JadwalController::class, 'jadwalGuru'])->name('guru.jadwal');
    });
});

// auth page

Route::group(['middleware' => ['authpage']], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');
});
