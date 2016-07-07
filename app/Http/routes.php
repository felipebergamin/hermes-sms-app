<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/home', function () {
    return view('home');
});

Route::get('/enviarSms', function () {
    return view('sms_unico');
});

Route::get('/enviarLote', function () {
    return view('smsLote');
});

Route::get('/usuarios', function () {
    return view('usuarios');
});

Route::get('/listaBranca', function () {
    return view('lista_branca');
});

Route::get('/sobre', function () {
    return view('sobre');
});