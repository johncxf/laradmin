@extends('admin.layouts.app')
@section('title', '编辑栏目')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-index-tab" href="/admin/category" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    栏目列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-edit-tab" data-toggle="pill" href="#custom-tabs-edit" role="tab" aria-controls="custom-tabs-edit" aria-selected="false">
                    编辑栏目
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-edit" role="tabpanel" aria-labelledby="custom-tabs-edit-tab">
                @component('admin.component.form', ['url' => "/admin/category/{$category['id']}", 'method' => 'put'])
                    @slot('form_body')
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">栏目名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="name" value="{{$category['name']}}">
                            </div>
                            <span class="col-sm-5 text-danger">*</span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">栏目别名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="alias" value="{{$category['alias']}}">
                            </div>
                            <span class="col-sm-5 text-danger">*</span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">图标</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" placeholder="" name="icon" value="{{$category['icon']}}">
                            </div>
                            <span class="col-sm-5 text-muted"><a href="http://www.fontawesome.com.cn/faicons/" target="_blank">图标样式参考</a></span>

                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">跳转地址</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="url" value="{{$category['url']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">状态</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="status">
                                    <option value="1" {{$category['status']?'selected':''}}>显示</option>
                                    <option value="0" {{$category['status']==0?'selected':''}}>隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">父级栏目</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="pid">
                                    <option selected="selected" value="0">顶级栏目</option>
                                    @foreach($categories as $cate)
                                        <option value="{{$cate['id']}}"
                                                {{$cate['_selected']?'selected':''}}
                                                {{$cate['_disabled']?'disabled':''}}>
                                            {!! $cate['_name'] !!}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">排序</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" placeholder="" name="sort" value="{{$category['sort']}}">
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