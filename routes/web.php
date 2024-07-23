<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PDFController;
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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

});

//AUTH
Route::controller(LoginController::class)->group(function() {
    //LOGIN
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');

    //REGISTER
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    // Route::get('/login', 'login')->name('login');
    // Route::post('/authenticate', 'authenticate')->name('authenticate');
    // Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});


//SEND EMAIL
Route::get('send-email-pdf', [PDFController::class, 'index']);
