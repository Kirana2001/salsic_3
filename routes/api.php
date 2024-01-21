<?php

use App\Http\Controllers\Api\ApiArticleController;
use App\Http\Controllers\Api\ApiAuthenticationController;
use App\Http\Controllers\Api\ArenaApiController;
use App\Http\Controllers\Api\AtletApiController;
use App\Http\Controllers\Api\PelatihApiController;
use App\Http\Controllers\Api\WasitApiController;
use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\ApiJadwalController;
use App\Http\Controllers\Api\ApiPemudaController;
use App\Http\Controllers\Api\ApiProfileController;
use App\Http\Controllers\Api\DocumentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware('cors:api')->group(function () {
    Route::controller(ApiAuthenticationController::class)->group(function () {
        Route::post('/login', 'login');
        Route::get('/logout', 'logout');
        Route::post('/register', 'register');
        Route::get('/cektoken', 'cektoken');
        Route::post('/lupapassword', 'lupapassword');
        Route::post('/lupapasswordotp', 'lupapasswordotp');
        Route::post('/lupapasswordinput', 'lupapasswordinput');

        Route::middleware('auth:api')->group(function () {
            Route::get('/current-user', [ApiAuthenticationController::class, 'currentUser']);

            Route::controller(ApiArticleController::class)->group(function () {
                Route::get('/artikel', 'getArticles');
                Route::get('/artikel/{id}', 'getArticleById');
            });

            Route::controller(ApiProfileController::class)->group(function () {
                Route::get('/profiles', 'getProfiles');
                Route::get('/profiles/{id}', 'getProfileById');
            });

            Route::controller(ApiEventController::class)->group(function () {
                Route::get('/event', 'getEvents');
                Route::get('/event/{id}', 'getEventById');
            });

            Route::controller(ApiJadwalController::class)->group(function () {
                Route::get('/jadwal', 'getJadwal');
                Route::get('/jadwal/{id}', 'getJadwalById');
            });

            Route::controller(AtletApiController::class)->group(function () {
                Route::post('/pendaftaran-atlet', 'store');
                Route::get('/pendaftaran-atlet', 'index');
                Route::get('/pendaftaran-atlet-detail', 'show');
                Route::post('/pendaftaran-atlet-edit', 'update');
            });

            Route::controller(PelatihApiController::class)->group(function () {
                Route::post('/pendaftaran-pelatih', 'store');
                Route::get('/pendaftaran-pelatih', 'index');
                Route::get('/pendaftaran-pelatih-detail', 'show');
                Route::post('/pendaftaran-pelatih-edit', 'update');
            });

            Route::controller(WasitApiController::class)->group(function () {
                Route::post('/pendaftaran-wasit', 'store');
                Route::get('/pendaftaran-wasit', 'index');
                Route::get('/pendaftaran-wasit-detail', 'show');
                Route::post('/pendaftaran-wasit-edit', 'update');
            });

            Route::controller(ArenaApiController::class)->group(function () {
                Route::get('/arena', 'index');
                Route::get('/arena-detail', 'show');
                Route::post('/pinjam-arena', 'lendArena');
                Route::get('/riwayat-pinjam-arena', 'lendHistory');
                Route::get('/riwayat-pinjam-arena-detail', 'lendHistoryDetail');
            });

            Route::controller(ApiPemudaController::class)->group(function () {
                Route::post('/pendaftaran-pemuda', 'store');
                Route::get('/pendaftaran-pemuda', 'index');
                Route::get('/pendaftaran-pemuda-detail', 'show');
                Route::post('/pendaftaran-pemuda-edit', 'update');
            });

            Route::controller(DocumentApiController::class)->group(function () {
                Route::post('/upload-documents-multiple', 'uploadDocuments');
            });
        });
    });
});
