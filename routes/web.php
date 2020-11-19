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

Route::get('/short', function(){
    return view('url.short');
});
Route::post('/short', 'App\Http\Controllers\URL\UrlController@short');
Route::get('/short/{link}', 'App\Http\Controllers\URL\UrlController@shortLink');