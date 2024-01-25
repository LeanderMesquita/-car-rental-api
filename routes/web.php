<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function(){
    Route::get('/clientes', function(){return view('app.clientes');})->name('clientes');
    Route::get('/locacoes', function(){return view('app.locacoes');})->name('locacoes');
    Route::get('/marcas', function(){return view('app.marcas');})->name('marcas');
    Route::get('/modelos', function(){return view('app.modelos');})->name('modelos');
    Route::get('/carros', function(){return view('app.carros');})->name('carros');
});
