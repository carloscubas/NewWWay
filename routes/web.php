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
    return view('welcome');
});


Route::get('api/produtos', 'ProdutoController@listarest');

Route::get('/produtos', 'ProdutoController@lista');
Route::get('/produtos/novo', 'ProdutoController@novo');
Route::post('/produto/inclui', 'ProdutoController@inclui');
Route::get('/produto/apaga', 'ProdutoController@apaga');
Route::get('/produto/edita', 'ProdutoController@edita');
Route::post('/produto/pesquisa', 'ProdutoController@pesquisa');

Route::get('/categorias', 'CategoriaController@lista');
Route::get('/categorias/novo', 'CategoriaController@novo');
Route::post('/categoria/inclui', 'CategoriaController@inclui');
Route::get('/categoria/apaga', 'CategoriaController@apaga');
Route::get('/categoria/edita', 'CategoriaController@edita');
Route::post('/categoria/pesquisa', 'CategoriaController@pesquisa');