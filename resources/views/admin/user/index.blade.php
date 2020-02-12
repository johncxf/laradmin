@extends('admin.layouts.app')
@section('title', '本站用户')
@section('content')
    @component('admin.component.card')
        @slot('card_head')
            <form action="admin/user" method="GET" class="form-horizontal">
                <div class="row col-sm-12">
                    <div class="col-sm-1">
                        <input type="text" class="form-control" id="" placeholder="uid" name="uid">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="" placeholder="昵称" name="nickname">
                    </div>
                    <div class="col-sm-2">
                        <select class="custom-select">
                            <option value="0">用户类型</option>
                            <option value="2">会员</option>
                            <option value="1">管理员</option>
                        </select>
                    </div>

                    <div class="float-right">
                        <button type="button" class="btn btn-info">搜索</button>
                    </div>
                </div>
            </form>
        @endslot
        @slot('card_body')
            @component('admin.component.table', ['have_tfoot' => true])
                @slot('thead')
                    <tr role="row">
                        <th class="text-center">UID</th>
                        <th class="text-center">头像</th>
                        <th class="text-center">用户昵称</th>
                        <th class="text-center">邮箱</th>
                        <th class="text-center">手机号</th>
                        <th class="text-center">用户类型</th>
                        <th class="text-center">最后登录IP</th>
                        <th class="text-center">最后登录时间</th>
                        <th class="text-center">注册时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                @endslot
                @slot('tbody')
                    @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{$user->id}}</td>
                            <td>
                                <img src="{{asset($user->avatar?$user->avatar:'img/default/avatar.jpg')}}" alt="" style="width: 35px;height: 35px;">
                            </td>
                            <td class="text-center">{{$user->nickname}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->mobile}}</td>
                            <td class="text-center">{{$user->user_type==2?'会员':'VIP'}}</td>
                            <td class="text-center">{{$user->last_login_ip}}</td>
                            <td class="text-center">{{$user->last_login_time}}</td>
                            <td class="text-center">{{$user->create_time}}</td>
                            <td class="text-center">
                                <a href=""><span class="text-info">详情</span></a>
                                <span class="text-muted">|</span>
                                @if($user->user_status == 1)
                                    <a href=""><span class="text-info">拉黑</span></a>
                                @else
                                    <a href=""><span class="text-info">启用</span></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endslot
                @slot('tfoot')
                    <tr role="row">
                        <th class="text-center">UID</th>
                        <th class="text-center">头像</th>
                        <th class="text-center">用户昵称</th>
                        <th class="text-center">邮箱</th>
                        <th class="text-center">手机号</th>
                        <th class="text-center">用户类型</th>
                        <th class="text-center">最后登录IP</th>
                        <th class="text-center">最后登录时间</th>
                        <th class="text-center">注册时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                @endslot
            @endcomponent
        @endslot
        @slot('card_foot')
            {{$users->links()}}
        @endslot
    @endcomponent
@endsection
