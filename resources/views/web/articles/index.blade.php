@extends('layouts.web')

@section('content')
<ul class="home post-list">
    @foreach ($articles as $article)
        <li class="post-list-item">
            <article class="post-block">
                <h2 class="post-title">
                    <a href="/{{ str_replace('-', '/', explode(' ', $article->publish_at)[0]) }}/{{ $article->slug }}/" class="post-title-link">
                        {{ $article->title }}
                    </a>
                </h2>
                <div class="post-time">Nov 15, 2016</div>
                <div class="post-content">Laravel 是个很有创造力的框架，它和 Mina 结合后是不是会更加强大？</div>
                <a href="/{{ str_replace('-', '/', explode(' ', $article->publish_at)[0]) }}/{{ $article->slug }}/" class="read-more">...more</a>
            </article>
        </li>
    @endforeach()
</ul>
@endsection
