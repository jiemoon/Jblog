<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Tag;

class ArticleRepository
{
    public function getPageListBySearchTitle($title = '', $size = 15)
    {
        $query = Article::latest();
        if(!empty($title)) {
            $query->where('title', 'like', '%'.$title.'%');
        }
        return $query->paginate($size)->toArray();
    }

    public function create(array $attributes)
    {
        if (isset($attributes['publish_at'])) {
            $attributes['publish_at'] = date('Y-m-d H:i:s',  strtotime($attributes['publish_at']));
            $attributes['status'] = 'published';
        }

        return Article::create($attributes);
    }

    public function byId($id)
    {
        return Article::find($id);
    }

    public function byIdIWithTags($id)
    {
        return Article::where('id', $id)->with('tags')->first();
    }

    public function normalizeTag(array $tags) {
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
}
