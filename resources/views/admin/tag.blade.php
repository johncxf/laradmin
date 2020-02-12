@extends('admin.layouts.app')
@section('title', '标签管理')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-index-tab" data-toggle="pill" href="#custom-tabs-index" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    标签列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="" data-toggle="modal" data-target="#addTag">
                    添加标签
                </a>
            </li>
            @component('admin.component.modal', ['id' => 'addTag', 'url' => '/admin/tag', 'title' => '添加标签'])
                <div class="form-group">
                    <label for="exampleInput1">标签名称</label>
                    <input type="text" class="form-control" id="" name="name" value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <label for="" class="col-form-label">类别</label>
                    <select class="custom-select" name="type">
                        <option selected="selected" value="article">文章</option>
                        <option value="resource">资源</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInput2">标签描述</label>
                    <input type="text" class="form-control" id="" name="remark">
                </div>
            @endcomponent
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-index" role="tabpanel" aria-labelledby="custom-tabs-index-tab">
                @component('admin.component.table', ['have_tfoot' => true])
                    @slot('thead')
                        <tr role="row">
                            <th width="6%">ID</th>
                            <th>标签名</th>
                            <th>备注</th>
                            <th>类别</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                    @slot('tbody')
                        @foreach($tags as $tag)
                            <tr>
                                <td class="text-center">{{$tag['id']}}</td>
                                <td>{{$tag['name']}}</td>
                                <td>{{$tag['remark']}}</td>
                                <td>{{$tag['type']}}</td>
                                <td class="text-center">
                                    <a href="" data-toggle="modal" data-target="#editTag{{$tag['id']}}"><span class="text-info">编辑</span></a>
                                    <span>|</span>
                                    <a href="javascript:;" onclick="delRecord({{$tag['id']}}, this)"><span class="text-danger">删除</span></a>
                                    <form action="/admin/tag/{{$tag['id']}}" method="post" hidden>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @component('admin.component.modal', ['id' => "editTag{$tag['id']}", 'url' => "/admin/tag/{$tag['id']}", 'title' => '添加标签', 'method' => 'put'])
                                <div class="form-group">
                                    <label for="exampleInput1">标签名称</label>
                                    <input type="text" class="form-control" id="" name="name" value="{{$tag['name']}}">
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-form-label">类别</label>
                                    <select class="custom-select" name="type">
                                        <option value="article" {{$tag['type']=='article'?'selected':''}}>文章</option>
                                        <option value="resource" {{$tag['type']=='resource'?'selected':''}}>资源</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">标签描述</label>
                                    <input type="text" class="form-control" id="" name="remark" value="{{$tag['remark']}}">
                                </div>
                            @endcomponent
                        @endforeach
                    @endslot
                    @slot('tfoot')
                        <tr role="row">
                            <th width="6%">ID</th>
                            <th>标签名</th>
                            <th>备注</th>
                            <th>类别</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection