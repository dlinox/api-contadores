<?php

use App\Http\Controllers\Aplicacion\AplicacionController as AppAplicacionController;
use App\Http\Controllers\Aplicacion\LoginController as AppLoginController;


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

Route::get('/', function () {
    return view('welcome');
});


Route::name('app.')->prefix('app')->group(function () {

    Route::get('login', [AppLoginController::class, 'index'])
        ->name('index');

    /**HOME VIEWS */
    Route::get('', [AppAplicacionController::class, 'index'])->middleware('auth')
        ->name('home');

    Route::get('/pagos', [AppAplicacionController::class, 'pagosView'])->middleware('auth')
        ->name('pagos');

    Route::get('certificados', [AppAplicacionController::class, 'certificadosView'])->middleware('auth')
        ->name('certificados');

    Route::get('tramites', [AppAplicacionController::class, 'tramitesView'])->middleware('auth')
        ->name('tramites');
});
