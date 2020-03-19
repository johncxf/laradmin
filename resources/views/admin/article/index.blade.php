@extends('admin.layouts.app')
@section('title', '文章管理')
@section('content')
    @component('admin.component.card')
        @slot('card_head')
            <form action="" method="GET" class="form-horizontal form-search" onsubmit="return false">
                @csrf
                <div class="row col-sm-12">
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="" placeholder="请输入文章标题" name="title">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="" placeholder="请输入文章作者" name="author">
                    </div>
                    <div class="col-sm-2">
                        <select name="status" class="custom-select">
                            <option value="0">所有文章</option>
                            <option value="1">未发布</option>
                            <option value="2">已发布</option>
                        </select>
                    </div>
                    <div class="float-right">
                        <input type="submit" class="btn btn-info" value="搜索" onclick="search()">
                    </div>
                </div>
            </form>
        @endslot
        @slot('card_body')
            <form method="post" class="js-ajax-form">
                @component('admin.component.table', ['have_tfoot' => true])
                    @slot('thead')
                        <tr role="row">
                            <th class="text-center" width="5%">ID</th>
                            <th class="text-center">文章标题</th>
                            <th class="text-center">作者</th>
                            <th class="text-center">所属栏目</th>
                            <th class="text-center">缩略图</th>
                            <th class="text-center" width="8%">状态</th>
                            <th class="text-center" width="15%">操作</th>
                        </tr>
                    @endslot
                    @slot('tbody')
                        @foreach($articles as $article)
                            <tr>
                                <td class="text-center">{{$article->id}}</td>
                                <td>{{$article->title}}</td>
                                <td class="text-center">{{$article->author}}</td>
                                <td class="text-center">{{$article->cate}}</td>
                                <td class="text-center">
                                    <img src="{{asset($article->thumb)}}" alt="" style="max-height: 60px;max-width: 100px">
                                </td>
                                <td class="text-center">
                                    {{$article->status==2?'已发布':'未发布'}}
                                </td>
                                <td class="text-center">
                                    <a href="/admin/article/{{$article->id}}/edit"><span class="text-info">编辑</span></a>
                                    <span>|</span>
                                    @if($article->status==2)
                                        <a href="/admin/article/issue/{{$article->id}}">撤销</a>
                                    @else
                                        <a href="/admin/article/issue/{{$article->id}}">发布</a>
                                    @endif
                                    <span>|</span>
                                    <a href="javascript:;" onclick="delRecord({{$article->id}},this)"><span class="text-danger">删除</span></a>
                                    <form action="/admin/article/{{$article->id}}" method="post" hidden>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                    @slot('tfoot')
                        <tr role="row">
                            <th class="text-center" width="5%">ID</th>
                            <th class="text-center">文章标题</th>
                            <th class="text-center">作者</th>
                            <th class="text-center">所属栏目</th>
                            <th class="text-center">缩略图</th>
                            <th class="text-center">状态</th>
                            <th class="text-center" width="10%">操作</th>
                        </tr>
                    @endslot
                @endcomponent
            </form>
        @endslot
        @slot('card_foot')
            {{$articles->links()}}
        @endslot
    @endcomponent
@endsection
@section('scripts')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
        });
        function search() {
            $.ajax({
                type: "get",
                dataType: "json",
                url: "/admin/article" ,
                data: $("form.form-search").serialize(),
                success: function (result) {
                    console.log(result);//打印服务端返回的数据(调试用)
                },
                error: function() {
                    // alert('异常');
                }
            });
        }
    </script>
@endsection
