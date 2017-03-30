<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasySlug\EasySlug\EasySlugFacade as EasySlug;
use App\Models\Article;
use App\Models\Tag;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->get('title');
        $query = Article::latest();
        if(!empty($title)) {
            $query->where('title', 'like', '%'.$title.'%');
        }
        $articles = $query->paginate(15)->toArray();
        return response()->json($articles);
    }

    public function edit($id)
    {
        $article = Article::where('id', $id)->with('tags')->first();
        return response()->json($article);
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|unique:articles|max:255',
            'summary' => 'required|max:255',
            'content' => 'required|min:100',
        ], [
            'title.required' => '标题不能为空',
            'title.unique' => '标题已存在',
            'title.max' => '标题长度不能超过255',
            'summary.required' => '摘要不能为空',
            'summary.max' => '摘要度不能超过255',
            'content.required' => '内容不能为空',
            'content.min' => '内容不能小于100个字',
        ]);

        $slug = EasySlug::generateUniqueSlug(request('title'), 'articles', "slug");
        $publish_at = request('publish_at');
        $status = 'draft';
        if (isset($publish_at)) {
            $publish_at = date('Y-m-d H:i:s',  strtotime($publish_at));
            $status = 'published';
        }

        $article = Article::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'slug' => $slug,
            'publish_at' => $publish_at,
            'status' => $status,
            'summary' => request('summary'),
            'content' => request('content')
        ]);

        $tags = $this->normalizeTag(request('tags'));
        $article->tags()->attach($tags);

        return response()->json(['status' => 'OK']);
    }

    private function normalizeTag(array $tags) {
        return collect($tags)->map(function($tag) {
            if(is_integer($tag)) {
                if (!is_null(Tag::find($tag))) {
                    Tag::find($tag)->increment('article_count');
                    return $tag;
                }
            }

            $new_tag = Tag::firstOrCreate(['name' => $tag]);
            $new_tag->article_count ++;
            $new_tag->save();
            return $new_tag->id;
        })->toArray();
    }

    public function destroy(Request $request)
    {
        $article = Article::find($request->get('id'));
        $article->delete();
        return response()->json(['status' => 'OK']);
    }
}
