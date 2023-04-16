<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AccesoController;
use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\ProveedorController;
use App\Http\Controllers\API\CuentaController;

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::controller(AccesoController::class)->group(function(){
    Route::post('registrar', 'registrar');
    Route::post('ingreso', 'ingreso');
    Route::post('validar', 'validar');
});
        
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('productos', ProductoController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::post('/cuenta/salir', [CuentaController::class, 'salir'])->name('salir');
    Route::post('/cuenta/cambiarUsuario', [CuentaController::class, 'cambiarUsuario'])->name('cambiar_usuario');
    Route::post('/cuenta/cambiarClave', [CuentaController::class, 'cambiarClave'])->name('cambiar_clave');
});
