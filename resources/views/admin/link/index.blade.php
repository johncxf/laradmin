@extends('admin.layouts.app')
@section('title', '链接管理')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-index-tab" data-toggle="pill" href="#custom-tabs-index" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    链接列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-create-tab" href="/admin/link/create" role="tab" aria-controls="custom-tabs-create" aria-selected="false">
                    添加链接
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-index" role="tabpanel" aria-labelledby="custom-tabs-index-tab">
                @component('admin.component.table', ['have_tfoot' => true])
                    @slot('thead')
                        <tr role="row">
                            <th>ID</th>
                            <th>链接名称</th>
                            <th>链接地址</th>
                            <th>链接类型</th>
                            <th>链接描述</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                    @slot('tbody')
                            @foreach($links as $link)
                                <tr>
                                    <td class="text-center">{{$link['id']}}</td>
                                    <td>{{$link['name']}}</td>
                                    <td>{{$link['url']}}</td>
                                    <td>{{$link['type']}}</td>
                                    <td>{{$link['remark']}}</td>
                                    <td class="text-center">
                                        <a href="/admin/link/{{$link['id']}}/edit"><span class="text-info">编辑</span></a>
                                        <span>|</span>
                                        <a href="javascript:;" onclick="delRecord({{$link['id']}},this)"><span class="text-danger">删除</span></a>
                                        <form action="/admin/link/{{$link['id']}}" method="post" hidden>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    @endslot
                    @slot('tfoot')
                        <tr role="row">
                            <th>ID</th>
                            <th>链接名称</th>
                            <th>链接地址</th>
                            <th>链接类型</th>
                            <th>链接描述</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection