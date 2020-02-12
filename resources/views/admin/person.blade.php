@extends('admin.layouts.app')
@section('title', '个人信息')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{asset($admin['avatar'])}}"
                                 alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{$admin['username']}}</h3>
                        <p class="text-muted text-center">{{$admin['username']}}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>手机号</b> <a class="float-right">{{$admin['mobile']}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>邮箱</b> <a class="float-right">{{$admin['email']}}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">账号信息</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> 登录时间</strong>
                        <p class="text-muted">
                            {{$admin['login_time']}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> 登录IP地址</strong>
                        <p class="text-muted">{{$admin['login_ip']}}</p>
                        <hr><strong><i class="fas fa-pencil-alt mr-1"></i> 上次修改时间</strong>
                        <p class="text-muted">{{$admin['update_at']}}</p>
                        <strong><i class="far fa-file-alt mr-1"></i> 账号创建时间</strong>
                        <p class="text-muted">{{$admin['create_at']}}</p>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-9">
                @component('admin.component.tab')
                    @slot('nav')
                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">修改信息</a></li>
                        <li class="nav-item"><a class="nav-link " href="#settings" data-toggle="tab">修改密码</a></li>
                    @endslot
                    @slot('body')
                        <div class="active tab-pane" id="activity">
                            <form action="/admin/person/update" class="form-horizontal" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputMobile" class="col-sm-2 col-form-label">手机号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputMobile"
                                               value="{{$admin['mobile']}}" name="mobile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">邮箱</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail"
                                               value="{{$admin['email']}}" name="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">头像</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="avatar">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-info">提交</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="settings">
                            <form action="/admin/person/reset" class="form-horizontal" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="inputPassword" placeholder="******"
                                        name="password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPasswordConfirmation" class="col-sm-2 col-form-label">确认密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="inputPasswordConfirmation" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-info">提交</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>
@endsection