<?php

use App\Http\Controllers\CompanyReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PenilaianAllController;
use App\Http\Controllers\PenilaianByUserController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PeriodePenilaianController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    // Route::group(['middleware' => ['checkrole:1']], function () {

    // });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::get('/get-chart-data/{category}', 'get_chart_data')->name('get-chart-data');
        Route::get('/summary', 'summary')->name('summary')->middleware('checkrole:1');
        Route::get('/get-chart-data-summary/{year}', 'get_chart_data_summary')->name('get-chart-data-summary')->middleware('checkrole:1');
        Route::get('/get-summary-by-year/{year}', 'get_summary_by_year')->name('get-summary-by-year')->middleware('checkrole:1');
    });

    Route::controller(PenilaianController::class)->group(function () {
        Route::get('/penilaian', 'index')->name('penilaian');
        Route::get('/penilaian/detail/{id}', 'penilaian_detail')->name('penilaian-detail');
        Route::post('/penilaian/detail/store', 'penilaian_detail_store')->name('penilaian-detail-store');
        Route::post('/penilaian/detail/preview', 'penilaian_detail_preview')->name('penilaian-detail-preview');
        Route::post('/penilaian/detail/autosave', 'penilaian_detail_autosave')->name('penilaian-detail-autosave');

        Route::get('/penilaian/detail-revisi/{id}', 'penilaian_detail_revisi')->name('penilaian-detail-revisi');
        Route::post('/penilaian/detail-revisi/store', 'penilaian_detail_revisi_store')->name('penilaian-detail-revisi-store');

        Route::get('/penilaian/detail-revisi-all/{id}', 'penilaian_detail_revisi_all')->name('penilaian-detail-revisi-all')->middleware('checkrole:1,3');
        Route::post('/penilaian/detail-revisi-all/store', 'penilaian_detail_revisi_store_all')->name('penilaian-detail-revisi-store-all')->middleware('checkrole:1,3');
    });

    Route::controller(CompanyReportController::class)->middleware('checkrole:1')->group(function (){
        Route::get('/company', 'index')->name('company');
        Route::get('/company/detail', 'company_detail')->name('company-detail');
        Route::get('/company/department', 'company_department')->name('company-department');
        Route::get('/company/employee', 'company_employee')->name('company-employee');
    });

    Route::controller(PenilaianAllController::class)->middleware('checkrole:1')->group(function (){
        Route::get('/penilaian-menu-all', 'index')->name('penilaian-menu-all');
        Route::get('/penilaian-menu-all/detail', 'penilaian_all_detail')->name('penilaian-menu-all-detail');
    });

    Route::controller(PeriodePenilaianController::class)->middleware('checkrole:1')->group(function (){
        Route::get('/penilaian-menu-periode', 'index')->name('penilaian-menu-periode');
        Route::get('/penilaian-menu-periode/create', 'create')->name('penilaian-menu-periode-create');
        Route::post('/penilaian-menu-periode/store', 'store')->name('penilaian-menu-periode-store');
        Route::get('/penilaian-menu-periode/edit/{id}', 'edit')->name('penilaian-menu-periode-edit');
        Route::patch('/penilaian-menu-periode/update/{id}', 'update')->name('penilaian-menu-periode-update');
        Route::post('/penilaian-menu-periode/delete/{id}', 'delete')->name('penilaian-menu-periode-delete');
        Route::post('/penilaian-menu-periode/toggle/{id}', 'toggle')->name('penilaian-menu-periode-toggle');
    });

    Route::controller(PenilaianByUserController::class)->middleware('checkrole:1')->group(function (){
        Route::get('/penilaian-menu-by-user', 'index')->name('penilaian-menu-by-user');
        Route::get('/penilaian-menu-by-user/detail', 'detail')->name('penilaian-menu-by-user-detail');
    });

    Route::controller(UserController::class)->middleware('checkrole:1')->group(function (){
        //User Akses
        Route::get('/user-akses', 'userAkses')->name('user-akses');
        Route::get('/user-akses/create', 'userAksesCreate')->name('user-akses-create');
        Route::post('/user-akses/store', 'userAksesStore')->name('user-akses-store');
        Route::get('/user-akses/edit/{id}', 'userAksesEdit')->name('user-akses-edit');
        Route::patch('/user-akses/update/{id}', 'userAksesUpdate')->name('user-akses-update');
        Route::post('/user-akses/delete/{id}', 'userAksesDelete')->name('user-akses-delete');

        //User Role
        Route::get('/user-roles', 'userRoles')->name('user-roles');
        Route::get('/user-roles/create', 'userRolesCreate')->name('user-roles-create');
        Route::post('/user-roles/store', 'userRolesStore')->name('user-roles-store');
        Route::get('/user-roles/edit/{id}', 'userRolesEdit')->name('user-roles-edit');
        Route::patch('/user-roles/update/{id}', 'userRolesUpdate')->name('user-roles-update');
        Route::post('/user-roles/delete/{id}', 'userRolesDelete')->name('user-roles-delete');
    });


});

//AUTH
Route::controller(LoginController::class)->group(function () {
    //LOGIN
    Route::get('/login', 'login')->name('login');
    // Route::post('/authenticate', 'authenticate')->name('authenticate');

    //REGISTER
    // Route::get('/register', 'register')->name('register');
    // Route::post('/store', 'store')->name('store');

    //LOGOUT
    Route::post('/logout', 'logout')->name('logout');

    //LOGIN WITH GOOGLE
    Route::get('/auth/google', 'redirectToGoogle')->name('auth-google');
    Route::get('/auth/google/callback', 'handleGoogleCallback')->name('auth-callback');
});


//SEND EMAIL
Route::get('send-email-pdf', [PDFController::class, 'index']);


// Unauthorized route
Route::get('/not-found', function () {
    return view('errors.not-found');
});
