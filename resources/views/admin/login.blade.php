<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台登录</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/admin/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box" style="margin-bottom: 150px">
    <div class="login-logo">
        <a href="#"><b>后台管理</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">登 录</p>
            <form action="{{route('admin.login')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="用户名" name="username" value="{{old('username')}}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="密码" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="验证码" name="captcha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-file"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <img src="{{ captcha_src('default') }}" onclick="this.src='/captcha/default?_'+Math.random()">
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">登 录</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@include('admin.errors._validate')
@include('admin.layouts._message')
<!-- /.login-box -->
<!-- jQuery v3.4.1-->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<script>
    $(function () {
        // 全局消息提示
        let message_success = $('#input-message-success').val();
        let message_danger = $('#input-message-danger').val();
        let message_warning = $('#input-message-warning').val();
        if (message_success !== undefined) {
            toastr.success(message_success)
        }
        if (message_danger !== undefined) {
            toastr.error(message_danger)
        }
        if (message_warning !== undefined) {
            toastr.warning(message_warning)
        }
        // validate
        let validate_error = $('#input-errors').val();
        if (validate_error !== undefined) {
            toastr.error(validate_error)
        }
    })
</script>
</body>
</html>
