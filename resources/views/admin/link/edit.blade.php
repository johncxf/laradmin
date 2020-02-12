@extends('admin.layouts.app')
@section('title', '编辑栏目')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-index-tab" href="/admin/link" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    链接列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-edit-tab" data-toggle="pill" href="#custom-tabs-edit" role="tab" aria-controls="custom-tabs-edit" aria-selected="false">
                    编辑链接
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-edit" role="tabpanel" aria-labelledby="custom-tabs-edit-tab">
                @component('admin.component.form', ['url' => "/admin/link/{$link['id']}", 'method' => 'put'])
                    @slot('form_body')
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">链接名称</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="name" value="{{$link['name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">链接地址</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="url" value="{{$link['url']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">链接描述</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="remark" value="{{$link['remark']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">链接类型</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="type">
                                    <option value="common" {{$link['type']=='common'?'selected':''}}>普通链接</option>
                                    <option value="friend" {{$link['type']=='friend'?'selected':''}}>友情链接</option>
                                </select>
                            </div>
                        </div>
                    @endslot
                    @slot('form_footer')
                        <button type="submit" class="btn btn-info">保存</button>
                        <a href="/admin/link" class="btn btn-default float-right">返回</a>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection