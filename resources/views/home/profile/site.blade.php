@extends('home.layouts.master')
@section('title', '账号设置')
@section('content')
    @php
        $user = auth()->user();
    @endphp
    @include('errors.validate')
    @include('errors.message')
    <h5>绑定邮箱</h5>
    <hr>
    <div class="">
        <form action="/profile/reset_email" method="post" class="home-profile-info-form">
            @csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">原邮箱号：</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="" value="{{$user['email']}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">新邮箱号：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="form-new-email" name="email" placeholder="请输入新邮箱号" value="{{old('email')}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">验证码：</label>
                <div class="col-sm-10">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="captcha" placeholder="填写验证码" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="button-send-captcha"
                            onclick="sendCaptcha()">发送验证码</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">保存</button>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </form>
        <form action="" method="post" id="ajax-form">
            @csrf
            <input type="hidden" name="email" value="" id="ajax-form-email">
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
        });
        function sendCaptcha() {
            $("div.alert").remove();
            let email = $("#form-new-email").val();
            let reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            if (email.length < 1) {
                alert('请填写新邮箱');
                return false;
            }
            if (!reg.test(email)) {
                alert('邮箱格式有误');
                return false;
            }
            $("#ajax-form-email").attr('value',email);
            $.ajax({
                type: 'post',
                dataType: 'json',
                data: $("#ajax-form").serialize(),
                url:'/mail/send_captcha',
                success: function(data) {
                    if (data['status'] === 'success') {
                        html = '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">'+data.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button></div>';
                        $("h5").append(html)
                    } else {
                        html = '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">'+data.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button></div>';
                        $("h5").append(html)
                    }
                },
                error: function(res) {
                    errors = res.responseJSON.errors;
                    html = '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">'+errors['email']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button></div>';
                    $("h5").append(html)
                }
            })
        }
    </script>
@endsection