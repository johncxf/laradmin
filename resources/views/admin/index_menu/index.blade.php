@extends('admin.layouts.app')
@section('title', '后台菜单')
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title col-2">菜单管理</h3>
                        <div class="col-sm-3 float-right" >
                            <div class=" float-right">
                                <a href="/admin/index_menu/create" class="btn btn-block btn-outline-info btn-sm">添加菜单</a>
                            </div>
                            <div class="col-sm-6 float-right">
                                <a href="/admin/index_menu/synchro" class="btn btn-block btn-outline-info btn-sm js-ajax-dialog-btn">初始化菜单</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="menus-table">
                            <thead>
                            <tr>
                                <th class="text-center">排序</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">菜单名称</th>
                                <th class="text-center">URL</th>
                                <th class="text-center">菜单类型</th>
                                <th class="text-center">显示状态</th>
                                <th class="text-center">备注</th>
                                <th class="text-center" style="width: 18%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                {!! $menus !!}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-center">排序</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">菜单名称</th>
                                <th class="text-center">URL</th>
                                <th class="text-center">菜单类型</th>
                                <th class="text-center">显示状态</th>
                                <th class="text-center">备注</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="col-1">
                    <button type="button" class="btn btn-block btn-info btn-sm" id="table-submit">排序</button>
                </div>
            </form>

        </div>
        <!-- /.col -->
    </div>
@endsection
@section('scripts')
    <!-- index.js -->
    <script src="{{asset('js/admin/menus/index.js')}}"></script>
@endsection