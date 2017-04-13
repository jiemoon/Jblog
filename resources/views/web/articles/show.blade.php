@extends('layouts.web')

@section('style')
<link rel="stylesheet" href="//cdn.bootcss.com/highlight.js/9.10.0/styles/atom-one-dark.min.css">
@endsection

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

@section('script')
<script src="//cdn.bootcss.com/highlight.js/9.10.0/highlight.min.js"></script>
<script>
    hljs.initHighlightingOnLoad();
</script>
@endsection
