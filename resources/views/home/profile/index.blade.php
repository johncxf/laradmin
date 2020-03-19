@extends('home.layouts.master')
@section('title', '个人主页')
@section('content')
    @include('errors.validate')
    @include('errors.message')
    <h5>个人主页</h5>
    <hr>
    <div class="card">
        <div class="card-header">
            账户信息
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <span>余额：</span>
                <span class="text-danger">{{$account->money}}</span>
                <a href="" class="btn btn-sm btn-success float-right">充值</a>
            </li>
            <li class="list-group-item">
                <span>金币：</span>
                <span class="text-danger">{{$account->gold}}</span>
                <a href="/account/gold" class="btn btn-sm btn-warning float-right">查看明细</a>
            </li>
            <li class="list-group-item">
                <span>积分：</span>
                <span class="text-danger">{{$account->score}}</span>
            </li>
        </ul>
    </div>
@endsection