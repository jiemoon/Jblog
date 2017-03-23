<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(15);
        return response()->json($articles);
    }

    public function store()
    {
        /**$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title')->default('');
            $table->string('slogan')->default('')->unique();
            $table->text('content');
            $table->index('slogan', 'idx_slogan');
            $table->enum('status', ['draft', 'published']);
        */

        Article::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'slogan' => request('slogan'),
            'content' => request('content')
        ]);

        return response()->json(['status' => 'OK']);
    }
}
