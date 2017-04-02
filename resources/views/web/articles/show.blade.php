@extends('layouts.web')

@section('content')
<div class="post">
    <article class="post-block">
        <h1 class="post-title">
            {{ $article->title }}
        </h1>
        <div class="post-time">
            {{ generate_article_date($article->publish_at) }}
        </div>
        <div class="post-content">
            {!! Markdown::convertToHtml($article->content) !!}
        </div>
    </article>
</div>
@endsection
