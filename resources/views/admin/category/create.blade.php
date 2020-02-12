@extends('admin.layouts.app')
@section('title', '添加栏目')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-index-tab" href="/admin/category" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    栏目列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-create-tab" data-toggle="pill" href="#custom-tabs-create" role="tab" aria-controls="custom-tabs-create" aria-selected="false">
                    添加栏目
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-create" role="tabpanel" aria-labelledby="custom-tabs-create-tab">
                @component('admin.component.form', ['url' => '/admin/category'])
                    @slot('form_body')
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">栏目名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="name" value="{{old('name')}}">
                            </div>
                            <span class="col-sm-5 text-danger">*</span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">栏目别名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="alias" value="{{old('alias')}}">
                            </div>
                            <span class="col-sm-5 text-danger">*</span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">图标</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" placeholder="" name="icon" value="{{old('icon')}}">
                            </div>
                            <span class="col-sm-5 text-muted"><a href="http://www.fontawesome.com.cn/faicons/" target="_blank">图标样式参考</a></span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">跳转地址</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="url" value="{{old('url')}}">
                            </div>
                            <span class="col-sm-5 text-danger">填写地址则该栏目以跳转地址为目标地址跳转</span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">状态</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="status">
                                    <option selected="selected" value="1">显示</option>
                                    <option value="0">隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">父级栏目</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="pid">
                                    <option selected="selected" value="0">顶级栏目</option>
                                    @foreach($categories as $cate)
                                        <option value="{{$cate['id']}}">{!! $cate['_name'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">排序</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" placeholder="" name="sort" value="0">
                            </div>
                        </div>
                    @endslot
                    @slot('form_footer')
                        <button type="submit" class="btn btn-info">保存</button>
                        <a href="/admin/category" class="btn btn-default float-right">返回</a>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection