<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CargarEstadosController;
use App\Http\Controllers\CalcularRatiosController;
use App\Http\Controllers\RatiosController;
use App\Http\Controllers\CargarCatalogoController;
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

/*Route::get('/analisis', function () {
    return view('welcome');
});*/


    Route::view('/login',"auth.login")->name('login');
    Route::view('/register',"auth.register")->name('register');
    Route::post('/validar-registro',[LoginController::class,'register'])->name('validar-registro');
    Route::post('/inicia-sesion',[LoginController::class,'login'])->name('inicia-sesion');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');

    Route::middleware(['auth'])->group(function(){
        Route::view('/',"home")->name('home');
        Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas');
        Route::post('/empresa/rol', [EmpresaController::class, 'setRolEmpresa'])->name('empresa.rol');

        Route::prefix('cargar-estados')->group(function(){
            Route::get('/', [CargarEstadosController::class, 'show'])->name('cargar-estados.show');
            Route::post('/', [CargarEstadosController::class, 'load'])->name('cargar-estados.load');
            Route::get('/exportar-excel', [CargarEstadosController::class, 'exportExcel'])->name('cargar-estados.export-excel');
            Route::get('/obtener/{periodo}', [CargarEstadosController::class, 'getEstados'])->name('cargar-estados.get-estados');
        });

        Route::get('/calcular-ratios', [CalcularRatiosController::class, 'show'])->name('calcular-ratios.show');

        Route::get('/ratios', [RatiosController::class, 'index'])->name('ratios');

        Route::prefix('cargar-catalogo')->group(function(){
            Route::get('/', [CargarCatalogoController::class, 'show'])->name('cargar-catalogo.show');
        });
    });


