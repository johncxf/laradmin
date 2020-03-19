@extends('admin.layouts.app')
@section('title', '角色管理')
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="/admin/role/permission" method="post" class="js-ajax-form">
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">权限设置</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <table width="100%" cellspacing="0" id="dnd-example">
                            <tbody>
                            {!! $permission_menus !!}
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="role_id" value="{{$role->id}}" />
                        <button class="btn btn-info js-ajax-submit" type="submit">保存</button>
                        <a href="/admin/role" class="btn btn-outline-secondary">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/admin/role/permission.js')}}"></script>
@endsection