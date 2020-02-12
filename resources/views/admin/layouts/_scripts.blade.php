<!-- jQuery v3.4.1-->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- menu.js和pjax不能同时使用，存在冲突 -->
<script src="{{asset('js/admin/menus/menu.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/admin/adminlte.js')}}"></script>
{{--<!-- jquery.pjax -->--}}
{{--<script src="{{asset('plugins/jquery-pjax/jquery.pjax.min.js')}}"></script>--}}
{{--<!-- pjax -->--}}
{{--<script src="{{asset('js/admin/pjax.js')}}"></script>--}}
<!-- 右侧边栏内容 -->
<script src="{{asset('js/admin/control.js')}}"></script>
<!-- wind.js -->
<script src="{{asset('js/wind.js')}}"></script>
<!-- ajaxForm.js -->
<script src="{{asset('js/ajaxForm.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<!-- common.js -->
<script src="{{asset('js/common.js')}}"></script>
@yield('scripts')