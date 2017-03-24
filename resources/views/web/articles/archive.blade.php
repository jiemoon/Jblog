@extends('layouts.web')

@section('content')
    <div class="archive">
        @foreach ($archives as $year => $articles)
            <h2 class="archive-year">{{ $year }}</h2>
            @foreach ($articles as $article)
                <div class="post-item">
                    <div class="post-time">
                        {{ generate_article_date($article->publish_at) }}
                    </div>
                    <a href="{{ generate_article_url($article) }}" class="post-title-link">{{ $article->title }}</a>
                </div>
            @endforeach
        @endforeach
    </div>
@endsection
