@extends('layouts.web')

@section('content')
<ul class="home post-list">
    @foreach ($articles as $article)
        <li class="post-list-item">
            <article class="post-block">
                <h2 class="post-title">
                    <a href="{{ $article->url() }}" class="post-title-link">
                        {{ $article->title }}
                    </a>
                </h2>
                <div class="post-time">
                    {{ $article->publish_date() }}
                </div>
                <div class="post-content">
                    {{ $article->summary }}
                    <a href="{{ $article->url() }}" class="read-more">...more</a>
                </div>
            </article>
        </li>
    @endforeach()
</ul>
@endsection
