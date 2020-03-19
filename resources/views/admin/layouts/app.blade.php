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
    <!-- 主导航栏 -->
    @include('admin.layouts._sidebar')
    <!-- 主要内容 -->
    <div class="content-wrapper" id="pjax-container">
{{--        <iframe name="mainiframe" id="mainiframe" width="100%" height="600" scrolling="auto" onload="changeFrameHeight()" src="" frameborder="0"></iframe>--}}
        @include('admin.layouts._header_page')
        <section class="content">
            @yield('content')
        </section>
    </div>
    <!-- 底部导航栏 -->
    @include('admin.layouts._footer')
    <!-- 右侧边控制栏 -->
    @include('admin.layouts._control_sidebar')
    <!-- 消息提示 -->
    @include('admin.errors._validate')
    @include('admin.layouts._message')
</div>
@include('admin.layouts._scripts')
</body>
</html>