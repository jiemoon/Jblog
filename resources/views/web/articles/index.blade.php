@extends('layouts.web')

@section('content')
<ul class="home post-list">
    @foreach ($articles as $article)
        <li class="post-list-item">
            <article class="post-block">
                <h2 class="post-title">
                    <a href="{{ generate_article_url($article) }}" class="post-title-link">
                        {{ $article->title }}
                    </a>
                </h2>
                <div class="post-time">
                    {{ generate_article_date($article->publish_at) }}
                </div>
                <div class="post-content">{{ $article->summary }}</div>
                <a href="{{ generate_article_url($article) }}" class="read-more">...more</a>
            </article>
        </li>
    @endforeach()
</ul>
@endsection
