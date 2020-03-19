@extends('home.layouts.app')
@section('title', '首页')
@section('heads')
    <link rel="stylesheet" href="{{asset('plugins/swiper/css/swiper.min.css')}}">
@endsection
@section('styles')
    <style type="text/css">
        .swiper-container {
            margin-top: -24px;
            width: 100%;
        }
        .swiper-container img{
            width: 100%;
            max-height: 500px;
        }
    </style>
@endsection
@section('content')
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @slide
                <div class="swiper-slide"><a href=""><img src="{{asset($field['content'])}}"></a></div>
            @endSlide
        </div>
        <!-- 如果需要分页器 -->
        <div class="swiper-pagination"></div>
    </div>
    <div class="row col-sm-12 mt-2">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div class="container">
                <div class="card">
                    <h5 class="card-header">推荐博文</h5>
                    <div class="card-body">
                        @foreach($articles as $article)
                            <div class="card mb-2" style="max-height: 270px;">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <a href="/article/{{$article->id}}.html">
                                            <img src="{{asset($article->thumb?$article->thumb:'img/admin/photo1.png')}}" class="card-img" alt="">
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
@section('scripts')
    <script src="{{asset('plugins/swiper/js/swiper.min.js')}}"></script>
    <script language="javascript">
        $(document).ready(function () {
            var mySwiper = new Swiper ('.swiper-container', {
                autoplay: {
                    delay: 3000,//3秒
                },
                keyboard : true,//键盘
                loop: true, // 循环模式选项
                // 如果需要分页器
                pagination: {
                    el: '.swiper-pagination',
                },
            });
        })
    </script>
@endsection
