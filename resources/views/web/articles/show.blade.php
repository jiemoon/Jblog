@extends('layouts.web')

@section('content')
<h1>
    {{ $article->title }}
</h1>
<div class="contetn">
    {!! Markdown::convertToHtml($article->content) !!}
</div>
@endsection
