<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'slug', 'summary', 'publish_at', 'status'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function url()
    {
        return url(sprintf("/%s/%s", str_replace('-', '/', explode(' ', $this->publish_at)[0]), $this->slug));
    }

    public function publish_date()
    {
        return date("M j, Y ", strtotime($this->publish_at));
    }
}
