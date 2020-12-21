<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('comments/{id}', 'CommentController@apiComments')->name('api.post.comments');
Route::post('comments/{id}', 'CommentController@apiCommentsCreate')->name('api.post.comments.create');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


