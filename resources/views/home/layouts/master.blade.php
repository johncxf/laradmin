<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Font Awesome4.7 Icons -->
    <link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- home.css -->
    <link rel="stylesheet" href="{{asset('css/home/home.css')}}">
    @yield('heads')
    @yield('styles')
</head>
<body>
<div id="app">
    @php
        $user = auth()->user();
    @endphp
    {{--顶部导航--}}
    @include('home.layouts.navbar')
    {{--主体部分--}}
    <main class="py-4">
        <div class="container">
            <div class="row col-sm-12">
                <div class="callout callout-dark col-sm-12">
                    <div class="row col-sm-12">
                        <div class="col-sm-1">
                            <a href="javascript:" onclick="clickAvatar()">
                                <img class="profile-user-img img-fluid img-circle user-avatar"
                                     src="{{asset($user['avatar']?$user['avatar']:'img/default/avatar.jpg')}}" alt="User profile picture">
                            </a>
                            <input type="file" style="display: none" name="avatar" class="home-avatar-file">
                        </div>
                        <div class="col-sm">
                            <div class="">
                                <span class="text-info">{{$user['nickname']}}</span>&nbsp;
                                @if($user['sex'] == 1)
                                    <span class="badge badge-light text-info"><i class="fa fa-mars"></i></span>
                                @elseif($user['sex'] == 2)
                                    <span class="badge badge-light text-danger"><i class="fa fa-venus"></i></span>
                                @else
                                    <span class="badge badge-light">未知</span>
                                @endif
                                <span class="badge badge-light text-success">{{$user['level']}}</span>
                            </div>
                            <div class="mt-2">
                                <i class="fa fa-fire"></i>&nbsp;<span>{{$user['signature']?$user['signature']:'未填写'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="col-sm-2 bg-white master">
                    @include('home.layouts.slider')
                </div>
                <div class="col-sm bg-white ml-3 master">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

</div>
<!-- jQuery v3.4.1-->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{asset('plugins/lrz/lrz.bundle.js')}}"></script>
<script src="{{asset('plugins/artDialog/dialog.js')}}"></script>
<!-- home.js -->
<script>
    $(function () {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        let domain = window.location.host;
        let protocol = window.location.protocol;
        let host = protocol+'//'+domain;
        $("input.home-avatar-file").change(function () {
            /* 压缩图片 */
            lrz(this.files[0], {
                // 压缩参数
                width: 300,
                height: 300
            }).then(function (rst) {
                /* 处理成功后执行 */
                rst.formData.append('base64img', rst.base64); // 添加额外参数
                $.ajax({
                    url: host+"/profile/upload_avatar",
                    type: "POST",
                    data: rst.base64,
                    success: function (data) {
                        if (data['status'] === 'success') {
                            $('img.user-avatar').attr("src", rst.base64);
                        } else {
                            alert('失败');
                        }
                    }
                });
            }).catch(function (err) {
                /* 处理失败后执行 */
            }).always(function () {
                /* 必然执行 */
            })
        })
    });
    function clickAvatar() {
        $("input.home-avatar-file").click();
    }
</script>
@yield('scripts')
</body>
</html>