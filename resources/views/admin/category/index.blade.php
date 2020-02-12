@extends('admin.layouts.app')
@section('title', '角色管理')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-index-tab" data-toggle="pill" href="#custom-tabs-index" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    栏目列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-create-tab" href="/admin/category/create" role="tab" aria-controls="custom-tabs-create" aria-selected="false">
                    添加栏目
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-index" role="tabpanel" aria-labelledby="custom-tabs-index-tab">
                @component('admin.component.table', ['have_tfoot' => true])
                    @slot('thead')
                        <tr role="row">
                            <th class="text-center" width="6%">排序</th>
                            <th class="text-center" width="6%">ID</th>
                            <th class="text-center">栏目名</th>
                            <th class="text-center">栏目别名</th>
                            <th class="text-center">图标</th>
                            <th class="text-center">跳转地址</th>
                            <th class="text-center" width="6%">状态</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                    @slot('tbody')
                        @foreach($categories as $cate)
                            <tr>
                                <td class="text-center">{{$cate['sort']}}</td>
                                <td class="text-center">{{$cate['id']}}</td>
                                <td>{!! $cate['_name'] !!}</td>
                                <td>{{$cate['alias']}}</td>
                                <td>{{$cate['icon']}}</td>
                                <td>{{$cate['url']}}</td>
                                @if($cate['status'] == 1)
                                    <td class="text-center">
                                        <span class="text-success">√</span>
                                    </td>
                                @else
                                    <td class="text-center">
                                        <span class="text-danger">×</span>
                                    </td>
                                @endif
                                <td class="text-center">
                                    <a href="/admin/category/{{$cate['id']}}/edit"><span class="text-info">编辑</span></a>
                                    <span>|</span>
                                    <a href="javascript:;" onclick="delRecord({{$cate['id']}},this)"><span class="text-danger">删除</span></a>
                                    <form action="/admin/category/{{$cate['id']}}" method="post" hidden>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                    @slot('tfoot')
                        <tr role="row">
                            <th class="text-center" width="6%">排序</th>
                            <th class="text-center" width="6%">ID</th>
                            <th class="text-center">栏目名</th>
                            <th class="text-center">栏目别名</th>
                            <th class="text-center">图标</th>
                            <th class="text-center">跳转地址</th>
                            <th class="text-center" width="6%">状态</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection