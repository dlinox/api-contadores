<?php

use App\Http\Controllers\Agremiados\AgremiadosController;
use App\Http\Controllers\Agremiados\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/auth/login', [LoginController::class, 'Login'])
    ->name('login');

Route::get('/auth/buscar-agremiado/{nummat}', [LoginController::class, 'buscarAgremiado'])
    ->name('buscar-agremiado');

Route::post('/auth/cuenta-agremiado', [AgremiadosController::class, 'crearUsuario'])
    ->name('cuenta-agremiado');


Route::get('/agremiado/pagos-pendientes', [AgremiadosController::class, 'getPagosPendientes'])
    ->name('pagos-pendientes');

Route::post('/agremiado/detalle-pagos', [AgremiadosController::class, 'getDetallePagos'])
    ->name('detalle-pagos');

Route::delete('/agremiado/pago-eliminar/{idpago}', [AgremiadosController::class, 'eliminarPago'])
    ->name('pago-eliminar');

Route::get('/agremiado/habil-estado', [AgremiadosController::class, 'getEstadoHabil'])
    ->name('habil-estado');


Route::get('/agremiado/habil-hasta', [AgremiadosController::class, 'getHastaHabil'])
    ->name('habil-hasta');


Route::get('/agremiado/detalle-habilidad', [AgremiadosController::class, 'getDetalleHabilidad'])
    ->name('detalle-habilidad');

Route::post('/agremiado/nuevo-pago', [AgremiadosController::class, 'guardarPago'])
    ->name('nuevo-pago');

Route::get('/agremiado/conceptos', [AgremiadosController::class, 'getConceptos'])
    ->name('conceptos');

Route::middleware('auth')->get('/auth/user', [LoginController::class, 'me'])
    ->name('me');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
