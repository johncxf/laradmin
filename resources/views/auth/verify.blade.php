@extends('home.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('邮箱验证') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('新的验证链接已发送到您的电子邮件地址。') }}
                        </div>
                    @endif
                    {{ __('在继续之前，请检查您的电子邮件以获取验证链接。') }}
                    {{ __('如果你没有收到邮件') }}, <a href="{{ route('verification.resend') }}">{{ __('单击此处重新发送') }}</a>.
                    如果邮箱填写错误，请联系管理员。
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
