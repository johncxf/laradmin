@extends('admin.layouts.app')
@section('title', '添加分类')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-index-tab" href="/admin/item" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    分类列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-create-tab" data-toggle="pill" href="#custom-tabs-create" role="tab" aria-controls="custom-tabs-create" aria-selected="false">
                    添加分类
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-create" role="tabpanel" aria-labelledby="custom-tabs-create-tab">
                @component('admin.component.form', ['url' => '/admin/item'])
                    @slot('form_body')
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">分类名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="name" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">备注</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="remark" value="{{old('remark')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">类别</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="type">
                                    <option selected="selected" value="article">文章</option>
                                    <option value="resource">资源</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">父级分类</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="pid">
                                    <option selected="selected" value="0">一级分类</option>
                                    @foreach($items as $item)
                                        <option value="{{$item['id']}}">{!! $item['_name'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endslot
                    @slot('form_footer')
                        <button type="submit" class="btn btn-info">保存</button>
                        <a href="/admin/item" class="btn btn-default float-right">返回</a>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection