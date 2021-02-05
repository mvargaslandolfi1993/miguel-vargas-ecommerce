<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login',[AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class,'logout'])->name('auth.logout');
    Route::post('refresh', [AuthController::class,'refresh'])->name('auth.refresh');
    Route::get('me', [AuthController::class,'me'])->name('auth.me');
    Route::post('register',[AuthController::class,'register'])->name('auth.register');

});