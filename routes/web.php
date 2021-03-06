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
Route::get('/', 'App\Http\Controllers\URL\UrlController@index');



    Route::post('/short', 'App\Http\Controllers\URL\UrlController@short');
    Route::get('/short/{link}', 'App\Http\Controllers\URL\UrlController@shortLink');
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
Route::get('/logout', 'App\Http\Controllers\URL\UrlController@logout');
