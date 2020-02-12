@extends('admin.layouts.app')
@section('title', '添加文章')
@section('heads')
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
@endsection
@section('content')
    <form action="/admin/article" method="post" class="row article-form">
        @csrf
        <div class="col-md-9">
            @component('admin.component.card')
                @slot('card_head')
                    <h3 class="card-title">撰写新文章</h3>
                @endslot
                @slot('card_body')
                    <div class="form-group">
                        <input type="text" class="form-control" id="" name="title" value="{{old('title')}}" placeholder="在此输入标题">
                    </div>
                    <div class="form-group">
                        <textarea class="textarea" name="content" hidden placeholder="Place some text here"
                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="" name="remark" value="{{old('remark')}}" placeholder="在此输入文章摘要">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="" name="author" value="{{old('author')}}" placeholder="署名">
                    </div>
                    <input type="hidden" name="status" value="0" class="input-article-status">
                @endslot
                @slot('card_foot')
                    <div class="float-right">
                        <button type="button" class="btn btn-default" onclick="createArticle('1')"><i class="fas fa-pencil-alt"></i> 保存到草稿箱</button>
                        <button type="button" class="btn btn-primary" onclick="createArticle('2')"><i class="fa fa-mouse-pointer"></i> 发表文章</button>
                    </div>
                    <a href="/admin/article" class="btn btn-default"><i class="fas fa-times"></i> 返回</a>
                @endslot
            @endcomponent
        </div>
        <div class="col-md-3">
            <a href="" class="btn btn-primary btn-block mb-3">草稿箱</a>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">基本属性</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">栏目</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="cid">
                                @foreach($categories as $cate)
                                    <option value="{{$cate['id']}}">{!! $cate['_name'] !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">置顶</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="is_top">
                                <option value="0" selected>否</option>
                                <option value="1">是</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">分类</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table width="100%" cellspacing="0" id="dnd-example">
                        <tbody>
                        {!! $items !!}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">标签</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-1">
                    @foreach($tags as $tag)
                        <input class="" type="checkbox" id="customCheckbox{{$tag['id']}}" name="tag_id[]" value="{{$tag['id']}}">
                        <label for="customCheckbox{{$tag['id']}}" class="">{{$tag['name']}}</label>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- 中文字体 -->
    <script src="{{asset('plugins/summernote/lang/summernote-zh-CN.min.js')}}"></script>
    <script>
        $(function () {
            // Summernote
            $('.textarea').summernote({
                lang:'zh-CN',
                height: 350,   // 定义编辑框高度
                minHeight: null,  // 定义编辑框最低的高度
                maxHeight: null,  // 定义编辑框最高德高度
            })
        });
        function createArticle(status) {
            $(".input-article-status").attr("value",status);
            $(".article-form").submit();
        }
    </script>
@endsection