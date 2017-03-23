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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/admin/login', 'Admin\AuthController@login')->name('admin.login');
Route::get('/admin/articles', 'Admin\ArticlesController@index')->middleware('jwt.auth');
Route::post('/admin/articles', 'Admin\ArticlesController@store')->middleware('jwt.auth');

