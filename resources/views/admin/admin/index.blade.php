@extends('admin.layouts.app')
@section('title', '管理员列表')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">
                    管理员列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">
                    添加管理员
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                @component('admin.component.table', ['have_tfoot' => true])
                    @slot('thead')
                        <tr role="row">
                            <th class="text-center">ID</th>
                            <th class="text-center">用户名</th>
                            <th class="text-center">角色</th>
                            <th width="10%" class="text-center">最后登录IP</th>
                            <th class="text-center">最后登录时间</th>
                            <th class="text-center">手机号</th>
                            <th class="text-center">邮箱</th>
                            <th class="text-center" width="8%">状态</th>
                            <th class="text-center" width="15%">操作</th>
                        </tr>
                    @endslot
                    @slot('tbody')
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{$admin['id']}}</td>
                                <td>{{$admin['username']}}</td>
                                <td>{{$admin['role']}}</td>
                                <td>{{$admin['login_ip']}}</td>
                                <td>{{$admin['login_time']}}</td>
                                <td>{{$admin['mobile']}}</td>
                                <td>{{$admin['email']}}</td>
                                <td>
                                    @if($admin['status'] == 1)
                                        正常
                                    @else
                                        已拉黑
                                    @endif
                                </td>
                                <td>
                                    @if($admin['id'] == 1)
                                        <div class="btn-group">
                                            <a href="" class="btn btn-info btn-sm disabled">编辑</a>
                                            <button type="submit" class="btn btn-danger btn-sm disabled">删除</button>
                                            <a href="" class="btn btn-warning btn-sm disabled">拉黑</a>
                                        </div>
                                    @else
                                        <div class="btn-group">
                                            <a href="{{route('admin.edit', $admin['id'])}}" class="btn btn-info btn-sm">编辑</a>
                                            <form action="{{route('admin.destroy',$admin['id'])}}" method="post">
                                                @csrf @method('DELETE')
                                                <input type="hidden" value="{{$admin['id']}}">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="btnSubmit({{$admin['id']}})" id="js-btn-delete-{{$admin['id']}}">
                                                    删除
                                                </button>
                                            </form>
                                            @if($admin['status'] == 1)
                                                <a href="/admin/admin/forbidden/{{$admin['id']}}" class="btn btn-warning btn-sm js-ajax-dialog-btn">拉黑</a>
                                            @else
                                                <a href="/admin/admin/enable/{{$admin['id']}}" class="btn btn-warning btn-sm js-ajax-dialog-btn">启用</a>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                    @slot('tfoot')
                        <tr role="row">
                            <th class="text-center">ID</th>
                            <th class="text-center">用户名</th>
                            <th class="text-center">角色</th>
                            <th width="10%" class="text-center">最后登录IP</th>
                            <th class="text-center">最后登录时间</th>
                            <th class="text-center">手机号</th>
                            <th class="text-center">邮箱</th>
                            <th class="text-center" width="8%">状态</th>
                            <th class="text-center" width="15%">操作</th>
                        </tr>
                    @endslot
                @endcomponent
                {{$admins->links()}}
            </div>
            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                @component('admin.component.form', ['url' => '/admin/admin'])
                    @slot('form_body')
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">用户名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="inputUsername" name="username" value="{{old('username')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">手机号</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" placeholder="" name="mobile" value="{{old('mobile')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">邮箱</label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" placeholder="" name="email" value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">密码</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" placeholder="" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">确认密码</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" placeholder="" name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">角色</label>
                            @foreach($roles as $role)
                                <div class="icheck-info d-inline" style="margin-left: 10px">
                                    <input type="checkbox" id="checkboxPrimary{{$role->id}}" name="roleid[]" value="{{$role->id}}">
                                    <label for="checkboxPrimary{{$role->id}}">
                                        {{$role->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endslot
                    @slot('form_footer')
                        <button type="submit" class="btn btn-info">保存</button>
                        <a href="" class="btn btn-default float-right">返回</a>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection