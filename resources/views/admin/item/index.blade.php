@extends('admin.layouts.app')
@section('title', '分类管理')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-index-tab" data-toggle="pill" href="#custom-tabs-index" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    分类列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-create-tab" href="/admin/item/create" role="tab" aria-controls="custom-tabs-create" aria-selected="false">
                    添加分类
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-index" role="tabpanel" aria-labelledby="custom-tabs-index-tab">
                @component('admin.component.table', ['have_tfoot' => true])
                    @slot('thead')
                        <tr role="row">
                            <th width="6%">ID</th>
                            <th>分类名</th>
                            <th>备注</th>
                            <th>类型</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                    @slot('tbody')
                        @foreach($items as $item)
                            <tr>
                                <td class="text-center">{{$item['id']}}</td>
                                <td>{!! $item['_name'] !!}</td>
                                <td>{{$item['remark']}}</td>
                                <td>{{$item['type']}}</td>
                                <td class="text-center">
                                    <a href="/admin/item/{{$item['id']}}/edit"><span class="text-info">编辑</span></a>
                                    <span>|</span>
                                    <a href="javascript:;" onclick="delRecord({{$item['id']}},this)"><span class="text-danger">删除</span></a>
                                    <form action="/admin/item/{{$item['id']}}" method="post" hidden>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                    @slot('tfoot')
                        <tr role="row">
                            <th width="6%">ID</th>
                            <th>分类名</th>
                            <th>备注</th>
                            <th>类型</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection