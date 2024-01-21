<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ArenaController;
use App\Http\Controllers\ArenaLendingController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AtletController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\PemudaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'loginView')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard']);
    Route::get('/atletExport', [FileController::class, 'atletExport']);
    Route::get('/pelatihExport', [FileController::class, 'pelatihExport']);
    Route::get('/wasitExport', [FileController::class, 'wasitExport']);

    Route::controller(UserController::class)->group(function () {
        Route::patch('/ubah-password/{id}',  'ubahPassSubmit');
        Route::get('/ubah-password',  'ubahPassView');
    });

    Route::middleware(['role:1'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::resource('/users', UserController::class);
            Route::get('/users-datatable', 'usersDatatable');
        });

        Route::controller(AtletController::class)->group(function () {
            Route::resource('/atlets', AtletController::class);
            Route::get('/atlets-datatable', 'atletsDatatable');
            Route::get('/atlets/{id}/update-status', 'updateStatus');
            Route::get('/pendaftaran-atlets', 'registrationIndex');
        });

        Route::controller(PelatihController::class)->group(function () {
            Route::resource('/pelatih', PelatihController::class);
            Route::get('/pelatih-datatable', 'pelatihDatatable');
            Route::get('/pelatih/{id}/update-status', 'updateStatus');
            Route::get('/pendaftaran-pelatih', 'registrationIndex');
        });

        Route::controller(WasitController::class)->group(function () {
            Route::resource('/wasit', WasitController::class);
            Route::get('/wasit-datatable', 'wasitDatatable');
            Route::get('/wasit/{id}/update-status', 'updateStatus');
            Route::get('/pendaftaran-wasit', 'registrationIndex');
        });

        Route::controller(ArenaController::class)->group(function () {
            Route::resource('/arena', ArenaController::class);
            Route::get('/arena-datatable', 'arenaDatatable');
        });

        Route::controller(ArenaLendingController::class)->group(function () {
            Route::resource('/peminjaman-arena', ArenaLendingController::class);
            Route::get('/peminjaman-arena-datatable', 'arenaLendingDatatable');
            Route::patch('/peminjaman-arena/{id}/update-status', 'updateArenaLendingStatus');
        });

        Route::controller(ArticleController::class)->group(function () {
            Route::resource('/articles', ArticleController::class);
            Route::get('/articles-datatable', 'articleDatatable');
        });

        Route::controller(EventController::class)->group(function () {
            Route::resource('/events', EventController::class);
            Route::get('/events-datatable', 'eventDatatable');
        });

        Route::controller(ProfileController::class)->group(function () {
            Route::resource('/profiles', ProfileController::class);
            Route::get('/profiles-datatable', 'profileDatatable');
        });

        Route::controller(PemudaController::class)->group(function () {
            Route::resource('/pemudas', PemudaController::class);
            Route::get('/pemudas-datatable', 'pemudaDatatable');
            Route::get('/pendaftaran-pemudas', 'registrationIndex');
        });

        Route::controller(AnggotaController::class)->group(function () {
            Route::resource('/anggotas', AnggotaController::class);
            Route::get('/anggotas-datatable', 'anggotaDatatable');
        });

        Route::controller(JadwalController::class)->group(function () {
            Route::resource('/jadwal', JadwalController::class);
            Route::get('/jadwal-datatable', 'jadwalDatatable');
            Route::get('/jadwal/{id}/update-status', 'updateStatus');
        });
    });

    Route::middleware(['role:10,20,30,90'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/profile', 'profile');
            Route::get('/profile/edit', 'editProfile');
            Route::patch('/profile/update', 'updateProfile');
        });

    });
});
