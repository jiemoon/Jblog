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

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::post('/login', 'AuthController@login')->name('admin.login');

    Route::group(['middleware' => 'jwt.auth.admin'], function() {
        Route::get('/articles', 'ArticlesController@index');
        Route::post('/articles', 'ArticlesController@store');
        Route::delete('/articles', 'ArticlesController@destroy');
        Route::post('/images/upload', 'ImagesController@store');
        Route::get('/tags', 'TagsController@index');
    });
});


