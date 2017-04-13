<?php

Route::group(['domain' => 'blog.' . config('blog.domain')], function () {
    Route::get('/', function () {
        return redirect(url('/posts'));
    });
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', function() {
    $articles = App\Models\Article::where("status", "published")->orderBy('publish_at', 'DESC')->limit(10)->get();
    return view('web.articles.index', compact('articles'));
});

Route::get('/rss', 'Web\HomeController@rss');

Route::get('/{year}/{month}/{day}/{slug}', function($year, $month, $day, $slug) {
    $article = App\Models\Article::where('slug', $slug)->first();
    return view('web.articles.show', compact('article'));
})->where(['year' => '[2][0][1][5-7]', 'month' => '[0-1][0-9]', 'day' => '[0-3][0-9]', 'name' => '[a-z]+']);

Route::get('archives', function() {
    $articles = App\Models\Article::selectRaw('YEAR(publish_at) year, title, slug, publish_at')
        ->where("status", "published")
        ->orderBy('publish_at', 'DESC')->get();
    $archives = [];
    foreach ($articles as $article) {
        $archives[$article['year']][] = $article;
    }
    return view('web.articles.archive', compact('archives'));
});

// Route::group([
//     'namespace' => 'Web',
// ], function ($route) {
//     Auth::routes();
//     $route->get('/', 'HomeController@index');
// });

Route::get('/cpanel', function() {
    return view('cpanel');
});

/**
 * Admin
 */
// Route::group([
//     'prefix'    => 'admin',
//     'namespace' => 'Admin',
// ], function ($route) {
//     Auth::routes();
//     $route->get('/', 'HomeController@index');
// });
