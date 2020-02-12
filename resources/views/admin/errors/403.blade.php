@extends('admin.layouts.app')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-warning">403</h2>

        <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i>没有权限访问！</h3>
            <p>
                没有权限访问当前页面或没有操作权限, 你可以<a href="{{url('admin/index')}}">返回首页</a>或者联系管理员.
            </p>
{{--            <form class="search-form">--}}
{{--                <div class="input-group">--}}
{{--                    <input type="text" name="search" class="form-control" placeholder="Search">--}}
{{--                    <div class="input-group-append">--}}
{{--                        <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- /.input-group -->--}}
{{--            </form>--}}
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
<!-- /.content -->
@endsection