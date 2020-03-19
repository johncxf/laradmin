@extends('admin.layouts.app')
@section('title', '编辑菜单')
@section('content')
    <div class="card card-info col-12">
        <!-- form start -->
        <form action="{{route('index_menu.update', $menu->id)}}" method="post" class="form-horizontal" style="margin-left: 100px">
            @csrf
            {{--伪造表单--}}
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label">上级菜单:</label>
                    <select name="parentId" class="form-control select2 select2-danger col-sm-3" data-dropdown-css-class="select2-danger" style="width: 100%;margin-left: 8px">
                        <option selected="selected" value="0">作为一级菜单
                        {!! $select_menus !!}
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-sm-1 col-form-label">名称:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="{{$menu->name}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">URL:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="url" value="{{$menu->url}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">权限规则:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="permission" value="{{$menu->permission}}" readonly>
                    </div>
                    <span class="col-sm-5 text-muted">不支持修改操作</span>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">图标:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="icon" value="{{$menu->icon}}">
                    </div>
                    <span class="col-sm-5 text-muted"><a href="http://www.fontawesome.com.cn/faicons/" target="_blank">图标样式参考</a></span>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">备注:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="remark" value="{{$menu->remark}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-1">状态:</label>
                    <select name="status" class="form-control select2 select2-danger col-sm-3" data-dropdown-css-class="select2-danger" style="width: 100%;margin-left: 8px">
                        <option selected="selected" value="1">显示</option>
                        {{$status_selected=empty($menu->status)?"selected":""}}
                        <option value="0" {{$status_selected}}>隐藏</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-sm-1">类型:</label>
                    <select name="type" class="form-control select2 select2-danger col-sm-3" data-dropdown-css-class="select2-danger" style="width: 100%;margin-left: 8px">
                        <option selected="selected" value="1">权限认证+菜单</option>
                        {{$type_selected=empty($menu->type)?"selected":""}}
                        <option value="0" {{$type_selected}}>菜单</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">排序:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="sort" value="{{$menu->sort}}">
                    </div>
                </div>
            </div>
        @include('admin.errors._validate')
        <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">编辑</button>
                <a href="{{route('index_menu.index')}}" class="btn btn-outline-secondary">返回</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
@endsection