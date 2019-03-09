<?php

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
    // return view('welcome');
    return redirect('dashboard');
});

Route::get('/agency', "con_desempenhoController@index");


Route::get('dashboard', "con_desempenhoController@index");

Route::post('relatorio', "con_desempenhoController@relatorio");
Route::post('pizza', "con_desempenhoController@pizza");
Route::post('grafico', "con_desempenhoController@grafico");
