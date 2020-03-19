@extends('home.layouts.master')
@section('title', '我的资源')
@section('content')
    @include('errors.validate')
    @include('errors.message')
    <div class="row">
        <div class="col-sm-10">
            <h5>我的资源</h5>
        </div>
        <div class="col-sm-2">
            <a href="/resource/create" class="btn btn-outline-success">上传资源</a>
        </div>
    </div>
    <hr>
    <div class="">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">名称</th>
                    <th class="text-center">类别</th>
                    <th class="text-center">所需积分</th>
                    <th class="text-center">允许下载</th>
                    <th class="text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                    <tr>
                        <td>{{$resource->title}}</td>
                        <td class="text-center">{{$resource->type}}</td>
                        <td class="text-center">{{$resource->gold}}</td>
                        <td class="text-center">
                            @if($resource->status)
                                <span class="text-success">√</span>
                                @else
                                <span class="text-danger">×</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="" data-toggle="modal" data-target="#exampleModalScrollable{{$resource->id}}">详情</a>
                            <span class="text-muted">|</span>
                            <a href="/resource/{{$resource->id}}/edit" class="text-success">编辑</a>
                            <span class="text-muted">|</span>
                            <form action="/resource/{{$resource->id}}" method="post" style="display: none" id="form-resource-{{$resource->id}}">
                                @csrf @method('DELETE')
                                <input type="hidden" value="{{$resource->id}}">
                            </form>
                            <a href="javascript:" class="text-danger btn-delete" onclick="submitBtn({{$resource->id}})">删除</a>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalScrollable{{$resource->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">详情</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">名称：{{$resource->title}}</li>
                                        <li class="list-group-item">类别：{{$resource->type}}</li>
                                        <li class="list-group-item">所属分类：{{$resource->item_name}}</li>
                                        <li class="list-group-item">标签：
                                            @foreach($resource->tags as $tag)
                                                <span class="badge badge-primary">{{$tag['name']}}</span>
                                            @endforeach
                                        </li>
                                        <li class="list-group-item">所需积分：{{$resource->gold}}</li>
                                        <li class="list-group-item">允许下载：{{$resource->status?'是':'否'}}</li>
                                        <li class="list-group-item">资源描述：{{$resource->remark}}</li>
                                        <li class="list-group-item">上传时间：{{$resource->create_at}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        {{$resources->links()}}
    </div>
@endsection
@section('scripts')
    <script>
        function submitBtn(rid) {
            var d = dialog({
                title: '提示',
                content: '删除后数据不可恢复，确定要删除吗？',
                okValue: '确定',
                ok: function () {
                    $("form#form-resource-"+rid).submit();
                    this.title('提交中…');
                    return false;
                },
                cancelValue: '取消',
                cancel: function () {}
            });
            d.show();
        }
    </script>
@endsection