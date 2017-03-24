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
        $this->validate(request(), [
            'title' => 'required|unique:articles|max:255',
            'content' => 'required|min:100',
        ], [
            'title.required' => '标题不能为空',
            'title.unique' => '标题已存在',
            'title.max' => '标题长度不能超过255',
            'content.required' => '内容不能为空',
            'content.min' => '内容不能小于100个字',
        ]);

        Article::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'slug' => request('slug'),
            'content' => request('content')
        ]);

        return response()->json(['status' => 'OK']);
    }
}
