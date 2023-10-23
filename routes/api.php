<?php

use App\Http\Controllers\Auth\AuthController;
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


Route::group([
    'prefix' => 'auth',
    'controller' => AuthController::class,
], function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::get('/details', 'details')->name('details');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/dashboard', 'dashboard')->middleware('jwt.verify')->name('dashboard');
});





