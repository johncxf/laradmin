<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts._meta')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @inject('webSiteInfo','App\Stores\Admin\WebSiteStore')

    <!-- 顶部导航 -->
    @include('admin.layouts._navbar')
    <!-- /顶部导航 -->

    <!-- 主导航栏 -->
    @include('admin.layouts._sidebar')
    <!-- /主导航栏 -->

    <!-- 主要内容 -->
    <div class="content-wrapper" id="pjax-container">
        @include('admin.layouts._header_page')
        <section class="content" >
            @yield('content')
        </section>
{{--        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">--}}
{{--            <i class="fas fa-chevron-up"></i>--}}
{{--        </a>--}}
    </div>
    <!-- /主要内容 -->

    <!-- 底部导航栏 -->
    @include('admin.layouts._footer')
    <!-- /底部导航栏 -->

    <!-- 右侧边控制栏 -->
    @include('admin.layouts._control_sidebar')
    <!-- /右侧边控制栏 -->

    <!-- 消息提示 -->
    @include('admin.errors._validate')
    @include('admin.layouts._message')
</div>
@include('admin.layouts._scripts')
</body>
</html>