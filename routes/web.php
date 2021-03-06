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

Route::get('/home', 'HomeController@index')->middleware();;

Route::get('/chat', 'ChatController@index');
Route::get('/chat/send-message', 'ChatController@sendMessage');


//Route::get('/chat/send-message', 'ChatController@sendMessage');
//Route::get('/chat/send-public-message', 'ChatController@sendPublicMessage');
//Route::get('/chat/send-private-message', 'ChatController@sendPrivateMessage');
