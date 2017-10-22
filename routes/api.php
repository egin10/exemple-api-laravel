<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('posts', 'PostController@posts');

Route::get('users', 'UserController@users');
Route::get('users/profile', 'UserController@profile')->middleware('auth:api');
Route::get('users/{id}', 'UserController@profileById')->middleware('auth:api');
Route::post('users/post', 'PostController@add')->middleware('auth:api');
Route::put('users/post/{post}', 'PostController@update')->middleware('auth:api');
Route::delete('users/post/{post}', 'PostController@delete')->middleware('auth:api');

Route::post('set/register', 'AuthController@register');
Route::post('set/login', 'AuthController@login');