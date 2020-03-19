@extends('home.layouts.app')
@section('title', '下载')
@section('content')
    <div class="row col-sm-12 mt-2">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div class="container" id="download-container">
                @include('errors.validate')
                @include('errors.message')
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h5 class="font-weight-bold">
                                <i class="fa fa-{{$resource->icon}}"></i>
                                {{$resource->showname}}
                            </h5>
                        </div>
                        <div class="">
                            <span class="ml-4 font-weight-lighter">{{$resource->remark}}</span>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-10">
                                <span class="text-muted">大小：<span class="text-info">{{$resource->size}}</span></span>&nbsp;
                                <span class="text-muted">上传者：{{$resource->author}}</span>&nbsp;
                                <span class="text-muted">上传时间：{{$resource->time}}</span>
                            </div>
                            <div class="col-sm">
                                <span>所需积分:</span>&nbsp;<span class="text-danger">{{$resource->gold}}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-9">
                                <a href="javascript:" class="btn btn-default btn-sm" onclick="downloadResource({{$resource->gold}},{{$resource->id}})">
                                    <i class="fa fa-download"></i> 立即下载
                                </a>
                                <a href="/download/star/{{$resource->id}}" class="btn btn-default btn-sm">
                                    @if($resource->is_star)
                                        <i class="fa fa-star"></i> 已收藏
                                    @else
                                        <i class="fa fa-star-o"></i> 收藏
                                    @endif
                                </a>
                            </div>
                            <div class="col-sm">
                                <span class="float-right text-muted">收藏数: {{$resource->stars}} - 下载量: {{$resource->downloads}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <h5 class="card-header">推荐资源</h5>
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
@section('scripts')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
        });
        function downloadResource(gold,rid) {
            let host = window.location.protocol+'//'+window.location.host;
            let url = host+'/download/make/'+rid;
            let elem = '确定要花费<span class="text-danger">'+gold+'</span>金币下载该资源吗？<br><span class="text-danger">仅首次下载需要支付</span>';
            let d = dialog({
                title: '提示',
                content: elem,
                okValue: '确定',
                ok: function () {
                    $(location).attr('href', url);
                },
                cancelValue: '取消',
                cancel: function () {}
            });
            d.show();
        }
    </script>
@endsection