@extends('home.layouts.master')
@section('title', '最新动态')
@section('content')
    @php
        $user = auth()->user();
    @endphp
    @include('errors.validate')
    @include('errors.message')
    <h5>收藏文章</h5>
    <hr>
    <div class="">
        <ul class="list-group list-group-flush">
            @foreach($article_stars as $key => $article_star)
                <li class="list-group-item">
                    <a href="/article/{{$article_star->article_id}}.html" class="text-decoration-none">
                        <span>{{$key + 1}}.</span>&nbsp;
                        {{$article_star->article_title}}
                    </a>
                    <span class="text-muted float-right">
                        {{$article_star->create_at}}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection