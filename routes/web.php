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

// Route::resource('items','ItemsController');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'],function () {
    Route::get('/', 'App\Http\Controllers\BooksController@index');
    Route::get('/books', 'App\Http\Controllers\BooksController@create');
    Route::post('/books', 'App\Http\Controllers\BooksController@store');
    Route::delete('/books/{book}', 'App\Http\Controllers\BooksController@destroy');
    Route::get('/books/{book}/edit', 'App\Http\Controllers\BooksController@edit');
    Route::put('/books/{book}', 'App\Http\Controllers\BooksController@update');
    Route::get('/books/{book}', 'App\Http\Controllers\BooksController@edit');
    Route::get('/books/{book}/show', 'App\Http\Controllers\BooksController@show');
});
