<?php

use App\Http\Controllers\LoginController;
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



Route::view('/analisis/login',"auth.login")->name('login');
Route::view('/analisis/register',"auth.register")->name('register');
Route::view('/analisis',"home")->middleware('auth')->name('home');

Route::post('/analisis/validar-registro',[LoginController::class,'register'])->name('validar-registro');
Route::post('/analisis/inicia-sesion',[LoginController::class,'login'])->name('inicia-sesion');
Route::get('/analisis/logout',[LoginController::class,'logout'])->name('logout');
