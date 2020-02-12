@extends('home.layouts.master')
@section('title', '基本资料')
@section('content')
    @php
        $user = auth()->user();
    @endphp
    @include('errors.validate')
    @include('errors.message')
    <div class="row">
        <div class="col-sm-10">
            <h5>个人资料</h5>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-outline-success" onclick="submitForm()">保存修改</button>
        </div>
    </div>
    <hr>
    <div class="">
        <form action="/profile/updateinfo" method="post" class="home-profile-info-form">
            @csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">用户名：</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="" value="{{$user['username']}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">我的昵称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="" name="nickname" value="{{$user['nickname']}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">我的性别：</label>
                <div class="col-sm-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="sex" class="custom-control-input" value="1"
                                {{$user['sex']==1?'checked':''}}>
                        <label class="custom-control-label" for="customRadioInline1">男</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="sex" class="custom-control-input" value="2"
                                {{$user['sex']==2?'checked':''}}>
                        <label class="custom-control-label" for="customRadioInline2">女</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">座右铭：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="" name="signature" value="{{$user['signature']}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">手机号码：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="" name="mobile" value="{{$user['mobile']}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">连续登陆天数：</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="" value="{{$user['successions']}}（天）">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">最后登录ip：</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="" value="{{$user['last_login_ip']}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">最后登录时间：</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="" value="{{$user['last_login_time']}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">注册时间：</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="" value="{{$user['create_time']}}">
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        function submitForm() {
            $(".home-profile-info-form").submit();
        }
    </script>
@endsection