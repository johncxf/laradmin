@extends('admin.layouts.app')
@section('title', '编辑管理员')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-home-tab" data-toggle="" href="/admin/admin" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">
                    管理员列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">
                    编辑管理员
                </a>
            </li>
        @endslot
        @slot('body')
            <form action="{{route('admin.update', $admin->id)}}" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="col-sm-1 col-form-label">用户名</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="inputUsername" name="username" value="{{$admin->username}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-1 col-form-label">手机号</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="inputMobile" placeholder="" name="mobile" value="{{$admin->mobile}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-1 col-form-label">邮箱</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="inputEmail" placeholder="" name="email" value="{{$admin->email}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-1 col-form-label">密码</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="inputPassword" placeholder="******" name="password" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-1 col-form-label">确认密码</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="inputPasswordConfirmation" placeholder="" name="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-1 col-form-label">角色</label>
                        @foreach($roles as $role)
                            <div class="icheck-info d-inline" style="margin-left: 10px">
                                @if(in_array($role->id, $role_ids))
                                    <input type="checkbox" id="checkboxPrimary{{$role->id}}" name="roleid[]" value="{{$role->id}}" checked>
                                @else
                                    <input type="checkbox" id="checkboxPrimary{{$role->id}}" name="roleid[]" value="{{$role->id}}">
                                @endif
                                <label for="checkboxPrimary{{$role->id}}">
                                    {{$role->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">保存</button>
                    <a href="{{route('admin.index')}}" class="btn btn-default float-right">返回</a>
                </div>
            </form>
        @endslot
    @endcomponent
@endsection