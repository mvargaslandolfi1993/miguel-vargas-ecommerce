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
//clientes
Route::get('/get/productos', [App\Http\Controllers\apis\ProductoController::class, 'getProductos'])->middleware('api', 'auth.role:1,0');

Route::get('/get/producto/{id}', [App\Http\Controllers\apis\ProductoController::class, 'getProducto'])->middleware('api', 'auth.role:1,0');

//solo vendedores
Route::group(['middleware' => ['api', 'auth.role:1']], function(){
	Route::post('/create/producto', [App\Http\Controllers\apis\ProductoController::class, 'create']);
	Route::post('/update/producto', [App\Http\Controllers\apis\ProductoController::class, 'update']);
	Route::post('/delete/producto', [App\Http\Controllers\apis\ProductoController::class, 'delete']);
});