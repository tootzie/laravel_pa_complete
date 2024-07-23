<?php

use App\Http\Controllers\PAController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/pa', PAController::class);
// Route::resource('/locationarea', LocationAreaController::class);
// Route::get('/locationarea', [LocationAreaController::class, 'index'])->name('locationarea');
// Route::post('/inputlocationarea', [LocationAreaController::class, 'store'])->name('inputlocationarea');
// Route::patch('/editlocationarea', [LocationAreaController::class, 'update'])->name('editlocationarea');
// Route::post('/deletelocationarea', [LocationAreaController::class, 'destroy'])->name('deletelocationarea');
