<?php

use App\Http\Controllers\AnalisisVerticalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CargarEstadosController;
use App\Http\Controllers\RatiosController;
use App\Http\Controllers\CargarCatalogoController;
use App\Http\Controllers\RatioTipoController;
use App\Http\Controllers\AnalisisHorizontalController;
use App\Http\Controllers\GraficaController;
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
        Route::get('/', [GraficaController::class, 'home'])->name('home');
        Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas');
        Route::post('/empresa/rol', [EmpresaController::class, 'setRolEmpresa'])->name('empresa.rol');

        Route::prefix('cargar-estados')->group(function(){
            Route::get('/', [CargarEstadosController::class, 'show'])->name('cargar-estados.show');
            Route::post('/', [CargarEstadosController::class, 'load'])->name('cargar-estados.load');
            Route::get('/exportar-excel', [CargarEstadosController::class, 'exportExcel'])->name('cargar-estados.export-excel');
            Route::get('/obtener/{periodo}', [CargarEstadosController::class, 'getEstados'])->name('cargar-estados.get-estados');
        });

        Route::get('/ratios', [RatiosController::class, 'index'])->name('ratios');

        Route::post('/ratios/calculo', [RatiosController::class, 'calculoRatios'])->name('ratios.calculo');


        Route::prefix('cargar-catalogo')->group(function(){
            Route::get('/', [CargarCatalogoController::class, 'show'])->name('cargar-catalogo.show');
        });

        Route::prefix('nacionales')->group(function(){
            Route::get('/',[RatioTipoController::class, 'show'])->name('nacionales.show');
            Route::get('/create',[RatioTipoController::class, 'create'])->name('nacionales.create');
            Route::post('/create',[RatioTipoController::class, 'store'])->name('nacionales.store');
            Route::get('/edit/{id}',[RatioTipoController::class, 'edit'])->name('nacionales.edit');
            Route::get('/update/{id}',[RatioTipoController::class, 'update'])->name('nacionales.update');
            Route::get('/delete/{id}',[RatioTipoController::class, 'destroy'])->name('nacionales.delete');
        });


        Route::get('/analisis-vertical', [AnalisisVerticalController::class, 'index'])->name('analisis-vertical');
        Route::get('/analisis-horizontal', [AnalisisHorizontalController::class, 'index'])->name('analisis-horizontal.index');

        Route::Get('/grafica/{id}/{inicio}/{fin}', [GraficaController::class, 'grafica'])->name('grafica.data');

    });


