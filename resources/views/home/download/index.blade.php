@extends('home.layouts.app')
@section('title', '下载')
@section('content')
    <div class="row col-sm-12 mt-2">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div class="container">
                <div class="card">
                    <h5 class="card-header">最新上传</h5>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($resources as $resource)
                                <li class="list-group-item">
                                    <div>
                                        <a href="/download/detail/{{$resource->id}}" class="text-decoration-none" style="color: #343A40">
                                            <span class="font-weight-bold" style="font-size: 18px">
                                                <i class="fa fa-{{$resource->icon}}"></i>
                                                {{$resource->title}}
                                            </span>
                                        </a>
                                        @foreach($resource->tags as $tag)
                                            <span class="badge badge-primary">{{$tag['name']}}</span>
                                        @endforeach
                                    </div>
                                    <div class="mt-2">
                                        <span class="ml-4 font-weight-lighter">{{$resource->remark}}</span>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-10">
                                            <span class="text-muted">大小：<span class="text-info">{{$resource->size}}</span></span>&nbsp;
                                            <span class="text-muted">上传者：{{$resource->author}}</span>&nbsp;
                                            <span class="text-muted">上传时间：{{$resource->time}}</span>
                                        </div>
                                        <div class="col-sm">
                                            <span>积分/金币:</span>&nbsp;<span class="text-danger">{{$resource->gold}}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer">
                        {{$resources->links()}}
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