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

Route::get('/', 'ClientesController@listar')->name('home');
Route::get('/formAdicionar', 'ClientesController@formAdicionar')->name('formAdicionar');
Route::get('/formEditar/{id}', 'ClientesController@formEditar')->name('formEditar');
Route::post('/editar/{id}', 'ClientesController@editar')->name('editar');
Route::post('/novo', 'ClientesController@novo')->name('novo');
Route::post('/delete', 'ClientesController@delete')->name('delete');
