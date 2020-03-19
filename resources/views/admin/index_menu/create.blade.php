@extends('admin.layouts.app')
@section('title', '添加菜单')
@section('content')
    <div class="card card-info col-12">
        <form action="{{route('index_menu.store')}}" method="post" class="form-horizontal" style="margin-left: 100px">
            @csrf
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
                        <input type="text" class="form-control" id="" name="name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">URL:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="" name="url">
                    </div>
                    <span class="col-sm-5 text-muted">根据路由规则添加，例：/admin/site/index</span>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">权限规则:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="permission" value="admin::上级菜单/控制器@方法名">
                    </div>
                    <span class="col-sm-5 text-muted">例：admin::system/SiteController@index</span>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">图标:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="" name="icon" value="far fa-circle">
                    </div>
                    <span class="col-sm-5 text-muted"><a href="http://www.fontawesome.com.cn/faicons/" target="_blank">图标样式参考</a></span>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">备注:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="" name="remark">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-1">状态:</label>
                    <select name="status" class="form-control select2 select2-danger col-sm-3" data-dropdown-css-class="select2-danger" style="width: 100%;margin-left: 8px">
                        <option selected="selected" value="1">显示</option>
                        <option value="0">隐藏</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-sm-1">类型:</label>
                    <select name="type" class="form-control select2 select2-danger col-sm-3" data-dropdown-css-class="select2-danger" style="width: 100%;margin-left: 8px">
                        <option selected="selected" value="1">权限认证+菜单</option>
                        <option value="0">菜单</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">排序:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="" name="sort" value="0">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">添加</button>
                <a href="/admin/index_menu" class="btn btn-outline-secondary">返回</a>
            </div>
        </form>
    </div>
@endsection