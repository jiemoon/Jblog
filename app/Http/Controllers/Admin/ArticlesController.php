<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Repositories\ArticleRepository;

class ArticlesController extends Controller
{
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index(Request $request)
    {
        $articles = $this->articleRepository->getPageListBySearchTitle($request->get('title'));
        return response()->json($articles);
    }

    public function edit($id)
    {
        $article = $this->articleRepository->byIdIWithTags($id);
        return response()->json($article);
    }

    public function store(StoreArticleRequest $request)
    {
        $status = 'draft';
        $data = [
            'user_id' => auth()->id(),
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'publish_at' => $request->get('publish_at'),
            'status' => $status,
            'summary' => $request->get('summary'),
            'content' => $request->get('content')
        ];

        $article = $this->articleRepository->create($data);
        $tags = $this->articleRepository->normalizeTag($request->get('tags'));
        $article->tags()->attach($tags);

        return response()->json(['status' => 'OK']);
    }

    public function genSlug() {
        $this->validate(request(), [
            'title' => 'required|max:255',
        ], [
            'title.required' => '标题不能为空',
            'title.max' => '标题长度不能超过255',
        ]);

        $slug = \ChineseSlug::generateUniqueSlug(request('title'), 'articles');
        // $slug = EasySlug::generateUniqueSlug($title, 'articles', "slug");
        return response()->json(['slug' => $slug]);
    }

    public function update(StoreArticleRequest $request, $id)
    {
        $article = $this->articleRepository->byId($id);

        $data = [
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'publish_at' => $request->get('publish_at'),
            'summary' => $request->get('summary'),
            'content' => $request->get('content'),
        ];

        if (isset($data['publish_at'])) {
            $data['publish_at'] = date('Y-m-d H:i:s',  strtotime($data['publish_at']));
            $data['status'] = 'published';
        } else {
            $data['status'] = 'draft';
        }

        $article->update($data);

        $tags = $this->articleRepository->normalizeTag(request('tags'));
        $article->tags()->sync($tags);

        return response()->json(['status' => 'OK']);
    }

    public function destroy(\App\Models\Article $article)
    {
        $article->delete();
        return response()->json(['status' => 'OK']);
    }
}
