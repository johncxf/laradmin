@extends('admin.layouts.app')
@section('title', '角色管理')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title col-2">角色列表</h3>
                    <div class="col-1" style="float:right;">
                        <button type="button" class="btn btn-block btn-outline-info btn-sm" data-toggle="modal" data-target="#addRole">
                            添加
                        </button>
                    </div>
                    @component('admin.component.modal', ['id' => 'addRole', 'url' => '/admin/role', 'title' => '添加角色'])
                        <div class="form-group">
                            <label for="exampleInput1">角色名称</label>
                            <input type="text" class="form-control" id="" name="name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput2">角色描述</label>
                            <input type="text" class="form-control" id="" name="remark">
                        </div>
                        <div class="form-group">
                            <label for="">角色状态</label>
                            <div class="col-sm-6">
                                <!-- radio -->
                                <div class="form-group row">
                                    <div class="custom-control custom-radio col-sm-5">
                                        <input class="custom-control-input" type="radio" id="customRadio1" name="status" value="1" checked="">
                                        <label for="customRadio1" class="custom-control-label">启用</label>
                                    </div>
                                    <div class="custom-control custom-radio col-sm-5">
                                        <input class="custom-control-input" type="radio" id="customRadio2" name="status" value="0">
                                        <label for="customRadio2" class="custom-control-label">禁用</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcomponent
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="menus-table">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">角色名称</th>
                            <th class="text-center">角色描述	</th>
                            <th class="text-center">状态</th>
                            <th class="text-center" width="16%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="text-center">{{$role->id}}</td>
                                <td class="text-center">{{$role->name}}</td>
                                <td class="text-center" style="width: 50%;">{{$role->remark}}</td>
                                @if($role->status == 1)
                                    <td class="text-center">显示</td>
                                @else
                                    <td class="text-center">隐藏</td>
                                @endif
                                <td class="text-center">
                                    @if($role->id == 1)
                                        {{--                                                    <font color="#cccccc">权限设置</font>|--}}
                                        {{--                                                    <font color="#cccccc">编辑</font> | <font color="#cccccc">删除</font>--}}
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success disabled btn-sm">权限设置</button>
                                            <button type="button" class="btn btn-info disabled btn-sm">编辑</button>
                                            <button type="button" class="btn btn-danger disabled btn-sm">删除</button>
                                        </div>
                                    @else
                                        {{--                                                    <a href="">权限设置</a> |--}}
                                        {{--                                                    <a href="{{route('role.edit', $role->id)}}">编辑</a> |--}}
                                        {{--                                                    <a href="{{route('role.destroy', $role->id)}}">删除</a>--}}
                                        <div class="btn-group">
                                            <a href="/admin/role/permission/{{$role->id}}" class="btn btn-success btn-sm">权限设置</a>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editRole{{$role->id}}">编辑</button>
                                            <form action="{{route('role.destroy',$role->id)}}" method="post">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" onclick="btnSubmit({{$role->id}})" id="js-btn-delete-{{$role->id}}">删除</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @component('admin.component.modal', ['id' => "editRole{$role->id}", 'url' => "/admin/role/{$role->id}", 'title' => '编辑角色', 'method' => 'PUT'])
                                <div class="form-group">
                                    <label for="exampleInput1">角色名称</label>
                                    <input type="text" class="form-control" id="" value="{{$role->name}}" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">角色描述</label>
                                    <input type="text" class="form-control" id="" value="{{$role->remark}}" name="remark">
                                </div>
                                <div class="form-group">
                                    <label for="">角色状态</label>
                                    <div class="col-sm-6">
                                        <!-- radio -->
                                        <div class="form-group row">
                                            <div class="custom-control custom-radio col-sm-5">
                                                <input class="custom-control-input" type="radio" id="customRadio1{{$role->id}}"
                                                       name="status" value="1" @if($role->status==1) checked="" @endif>
                                                <label for="customRadio1{{$role->id}}" class="custom-control-label">启用</label>
                                            </div>
                                            <div class="custom-control custom-radio col-sm-5">
                                                <input class="custom-control-input" type="radio" id="customRadio2{{$role->id}}"
                                                       name="status" value="0" @if($role->status==0) checked="" @endif>
                                                <label for="customRadio2{{$role->id}}" class="custom-control-label">禁用</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcomponent
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">角色名称</th>
                            <th class="text-center">角色描述	</th>
                            <th class="text-center">状态</th>
                            <th class="text-center" width="16%">操作</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection