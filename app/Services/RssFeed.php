<?php

namespace App\Services;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
    /**
     * Return the content of the RSS feed
    */
    public function getRSS()
    {
        if (Cache::has('rss-feed')) {
            // return Cache::get('rss-feed');
        }

        $rss = $this->buildRssData();
        Cache::add('rss-feed', $rss, 120);

        return $rss;
    }

    /**
      * Return a string with the feed data
      *
      * @return string
      */
    protected function buildRssData()
    {
        $now = Carbon::now();
        $feed = new Feed();
        $channel = new Channel();
        $channel
            ->title(config('blog.title'))
            ->description(config('blog.description'))
            ->url(url(config('blog.blog')))
            ->language('en')
            ->copyright('Copyright (c) '.config('blog.copyright'))
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);

        $articles = Article::where('publish_at', '<=', $now)
            ->where('status', 'published')
            ->orderBy('publish_at', 'desc')
            ->take(config('blog.rss_size'))
            ->get();

        $author = config('blog.author');

        foreach ($articles as $article) {
            $item = new Item();
            $item
                ->title($article->title)
                ->description($article->summary)
                ->author($author)
                ->url($article->url())
                ->pubDate(strtotime($article->publish_at))
                ->guid($article->url(), true)
                ->appendTo($channel);
        }

        $feed = (string)$feed;

        // Replace a couple items to make the feed more compliant
        $feed = str_replace(
            '<rss version="2.0">',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            $feed
        );

        $feed = str_replace(
            '<channel>',
            '<channel>'."\n".'    <atom:link href="'.url('/rss').
                '" rel="self" type="application/rss+xml" />',
            $feed
        );

        return $feed;
    }
}
