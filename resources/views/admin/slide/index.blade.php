@extends('admin.layouts.app')
@section('title', '幻灯片管理')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-index-tab" data-toggle="pill" href="#custom-tabs-index" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    幻灯片列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-create-tab" href="/admin/slide/create" role="tab" aria-controls="custom-tabs-create" aria-selected="false">
                    添加幻灯片
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
                            <th class="text-center">名称</th>
                            <th class="text-center">幻灯片</th>
                            <th class="text-center">类型</th>
                            <th class="text-center" width="6%">状态</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                    @slot('tbody')
                        @foreach($slides as $slide)
                            <tr>
                                <td class="text-center">{{$slide['sort']}}</td>
                                <td class="text-center">{{$slide['id']}}</td>
                                <td>{{$slide['name']}}</td>
                                <td class="text-center">
                                    <a href="{{asset($slide['content'])}}"><img src="{{asset($slide['content'])}}" alt="" style="max-height: 50px  ;"></a>
                                </td>
                                <td>{{$slide['type']}}</td>
                                @if($slide['status'] == 1)
                                    <td class="text-center">
                                        <span class="text-success">√</span>
                                    </td>
                                @else
                                    <td class="text-center">
                                        <span class="text-danger">×</span>
                                    </td>
                                @endif
                                <td class="text-center">
                                    <a href="/admin/slide/{{$slide['id']}}/edit"><span class="text-info">编辑</span></a>
                                    <span>|</span>
                                    <a href="javascript:;" onclick="delRecord({{$slide['id']}},this)"><span class="text-danger">删除</span></a>
                                    <form action="/admin/slide/{{$slide['id']}}" method="post" hidden>
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
                            <th class="text-center">名称</th>
                            <th class="text-center">幻灯片</th>
                            <th class="text-center">类型</th>
                            <th class="text-center" width="6%">状态</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection