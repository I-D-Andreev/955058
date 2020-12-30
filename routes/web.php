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

use App\Twitter;

app()->singleton('twitter', function($app){
    return new Twitter();
});


Route::any('/', function(){
    return redirect()->route('posts.index');
});


Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/create', 'PostController@create')->name('posts.create');
Route::post('/posts', 'PostController@store')->name('posts.store');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/posts/uploadImage', 'PostController@uploadImage')->name('posts.image.store');


Auth::routes();

Route::get('/posts/{id}/edit', 'PostController@edit')->name('posts.edit');
Route::put('/posts/{id}', 'PostController@update')->name('posts.update');
Route::get('/posts/{id}', 'PostController@show')->name('posts.show');