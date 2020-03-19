@extends('home.layouts.master')
@section('title', '最新动态')
@section('content')
    @php
        $user = auth()->user();
    @endphp
    @include('errors.validate')
    @include('errors.message')
    <h5>我的收藏</h5>
    <hr>
    <h6>文章</h6>
    <div class="">
        <ul class="list-group list-group-flush">
            @if(empty($article_stars))
                <span class="text-center text-muted">暂无收藏</span>
            @else
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
            @endif
        </ul>
    </div>
    <h6>资源</h6>
    <div class="">
        <ul class="list-group list-group-flush">
            @if(empty($resource_stars))
                <span class="text-center text-muted">暂无收藏</span>
            @else
                @foreach($resource_stars as $key => $resource_star)
                    <li class="list-group-item">
                        <a href="/download/detail/{{$resource_star->rid}}.html" class="text-decoration-none">
                            <span>{{$key + 1}}.</span>&nbsp;
                            {{$resource_star->title}}
                        </a>
                        <span class="text-muted float-right">
                        {{$resource_star->create_at}}
                    </span>
                    </li>
                @endforeach
            @endif

        </ul>
    </div>
@endsection