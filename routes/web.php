<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\UserController;
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

// Authentication Routes
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');
Route::get('register', [AuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
Route::get('logout', [AuthController::class, 'signOut'])->name('signout');

Route::post('/export-nasabah', [NasabahController::class, 'exportNasabah']);
// Nasabah
Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/', [NasabahController::class, 'index'])->name('dashboard');
        Route::post('/', [NasabahController::class, 'store']);
        Route::get('/detail-nasabah/{id}', [NasabahController::class, 'show']);
        Route::post('/detail-nasabah/{id}', [NasabahController::class, 'update']);
        Route::post('/import-nasabah', [NasabahController::class, 'importNasabah']);
        Route::get('/search-nasabah', [NasabahController::class, 'searchNasabah']);
        Route::get('/checkin-nasabah', [NasabahController::class, 'updateCheckin']);

        Route::get('/user', [UserController::class, 'index']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::post('/user/{id}', [UserController::class, 'update']);
    }
);
