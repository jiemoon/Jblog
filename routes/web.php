<?php
Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'namespace' => 'Web',
], function ($route) {
    Auth::routes();
    $route->get('/', 'HomeController@index');
});

Route::get('/cpanel', function() {
    return view('cpanel');
});

/**
 * Admin
 */
Route::group([
    'prefix'    => 'admin',
    'namespace' => 'Admin',
], function ($route) {
    Auth::routes();
    $route->get('/', 'HomeController@index');
});
