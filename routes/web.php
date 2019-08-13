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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('projects', 'ProjectController');
Route::post('projects/upload', 'ProjectController@upload');
Route::post('projects/destroyfile', 'ProjectController@destroyfile');

Route::get('projects/ajax/{state_id?}/cities', 'ProjectController@distrito');

//Postulantes
Route::get('projects/{id}/postulantes', 'PostulantesController@index');
Route::post('projects/{id}/postulantes/create', 'PostulantesController@create');
Route::post('savepostulante', 'PostulantesController@store');
Route::get('projects/{id}/postulantes/{idpostulante}', 'PostulantesController@show');
Route::post('postulantes/upload', 'PostulantesController@upload');
Route::post('postulantes/destroyfile', 'PostulantesController@destroyfile');

//Miembros
Route::post('projects/{id}/postulantes/createmiembro', 'PostulantesController@createmiembro');
Route::post('savemiembro', 'PostulantesController@storemiembro');

//Mensajes
Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages.index', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
  });
