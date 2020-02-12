@extends('admin.layouts.app')
@section('title', '编辑栏目')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-index-tab" href="/admin/item" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    分类列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-edit-tab" data-toggle="pill" href="#custom-tabs-edit" role="tab" aria-controls="custom-tabs-edit" aria-selected="false">
                    编辑分类
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-edit" role="tabpanel" aria-labelledby="custom-tabs-edit-tab">
                @component('admin.component.form', ['url' => "/admin/item/{$item['id']}", 'method' => 'put'])
                    @slot('form_body')
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">分类名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="name" value="{{$item['name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">备注</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="remark" value="{{$item['remark']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">类别</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="type">
                                    <option value="article" {{$item['type']=='article'?'selected':''}}>文章</option>
                                    <option value="resource" {{$item['type']=='resource'?'selected':''}}>资源</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">父级栏目</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="pid">
                                    <option selected="selected" value="0">顶级栏目</option>
                                    @foreach($items as $v)
                                        <option value="{{$v['id']}}"
                                                {{$v['_selected']?'selected':''}}
                                                {{$v['_disabled']?'disabled':''}}>
                                            {!! $v['_name'] !!}
                                        </option>
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