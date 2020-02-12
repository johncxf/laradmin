@extends('home.layouts.app')
@section('title', $category['name'])
@section('content')
    <div class="row col-sm-12 mt-2">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div class="container">
                <div class="card">
                    <h5 class="card-header">{{$category['name']}}</h5>
                    <div class="card-body">
                        @foreach($articles as $article)
                            <div class="card mb-2" style="max-height: 270px;">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <a href="/article/{{$article->id}}.html">
                                            <img src="{{asset('img/admin/photo1.png')}}" class="card-img" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{$article->title}}</h5>
                                            <p class="card-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{$article->remark}}
                                            </p>
                                            <p class="text-muted text-right">—— 作者：{{$article->author}}</p>
                                            <a href="/article/{{$article->id}}.html" class="btn btn-outline-success">阅读全文</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        {{$articles->links()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            @include('home.component.sidebar')
            @link(['limit' => 5])
        </div>
    </div>
@endsection