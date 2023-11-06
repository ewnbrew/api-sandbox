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

/* auth */
Route::group([
    'prefix' => 'auth',
    'controller' => AuthController::class,
    'middleware' => ['api']
], function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::middleware(['auth', '','jwt.verify'])->group(function(){
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/details', 'details')->name('details');
        Route::post('/logout', 'logout')->name('logout');
    });    
});

/* spotify */
Route::group([
    'prefix' => 'spotify',
    'middleware' => ['auth', 'jwt.verify', ''],
    'controller' => 'spotify',
], function() {
    // Route::post('/')
});





