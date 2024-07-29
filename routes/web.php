<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PenilaianController;
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

Route::group(['middleware' => 'auth'], function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::controller(PenilaianController::class)->group(function () {
        Route::get('/penilaian', 'index')->name('penilaian');
        Route::get('/penilaian/detail', 'penilaian_detail')->name('penilaian-detail');
        Route::get('/penilaian/detail-awal', 'penilaian_detail_awal')->name('penilaian-detail-awal');
    });
});

//AUTH
Route::controller(LoginController::class)->group(function () {
    //LOGIN
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');

    //REGISTER
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');

    //LOGOUT
    Route::post('/logout', 'logout')->name('logout');
});


//SEND EMAIL
Route::get('send-email-pdf', [PDFController::class, 'index']);
