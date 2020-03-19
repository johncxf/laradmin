@extends('admin.layouts.app')
@section('title', '编辑文章')
@section('heads')
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
@endsection
@section('content')
    <form action="/admin/article/{{$article['id']}}" method="post" class="row">
        @csrf
        @method('PUT')
        <input type="hidden" name="thumb">
        <div class="col-md-9">
            @component('admin.component.card')
                @slot('card_head')
                    <h3 class="card-title">编辑文章</h3>
                @endslot
                @slot('card_body')
                    <div class="form-group">
                        <input type="text" class="form-control" id="" name="title" value="{{$article['title']}}" placeholder="在此输入标题">
                    </div>
                    <div class="form-group">
                        <textarea class="textarea" name="content" hidden placeholder="Place some text here"
                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                        {!! $article['content'] !!}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" accept="image/jpeg" capture="camera" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">上传文章封面</label>
                        </div>
                    </div>
                    <div class="col-sm-6 row mb-3">
                        <div class="col-sm-2"></div>
                        <div class="col-sm ml-2" id="img-show">
                            <img src="{{asset($article['thumb'])}}" class="rounded" alt="" style="max-height: 150px;max-width: 450px">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="" name="remark" value="{{$article['remark']}}" placeholder="在此输入文章摘要">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="" name="author" value="{{$article['author']}}" placeholder="署名">
                    </div>
                @endslot
                @slot('card_foot')
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> 保存更改</button>
                    </div>
                    <a href="/admin/article" class="btn btn-default"><i class="fas fa-times"></i> 返回</a>
                @endslot
            @endcomponent
        </div>
        <div class="col-md-3">
            <a href="/admin/article" class="btn btn-primary btn-block mb-3">文章列表</a>
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
                                    <option value="{{$cate['id']}}" {{$cate['id']==$article['cid']?'selected':''}}>
                                        {!! $cate['_name'] !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">置顶</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="is_top">
                                <option value="0" {{$article['is_top']==0?'selected':''}}>否</option>
                                <option value="1" {{$article['is_top']==1?'selected':''}}>是</option>
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
                        <input class="" type="checkbox" id="customCheckbox{{$tag['id']}}"
                               name="tag_id[]" value="{{$tag['id']}}"
                               @if(in_array($tag['id'], $tagIds))
                               checked
                               @endif>
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
    <!-- 压缩上传 -->
    <script src="{{asset('plugins/lrz/lrz.bundle.js')}}"></script>
    <script>
        $(function () {
            // Summernote
            $('.textarea').summernote({
                lang:'zh-CN',
                height: 350,   // 定义编辑框高度
                minHeight: null,  // 定义编辑框最低的高度
                maxHeight: null,  // 定义编辑框最高德高度
            });
            $("input[type=file]").change(function () {
                $("img").remove();
                /* 压缩图片 */
                lrz(this.files[0], {
                    // 压缩参数
                    width: 900,
                    height: 600
                }).then(function (rst) {
                    /* 处理成功后执行 */
                    rst.formData.append('base64img', rst.base64); // 添加额外参数
                    img = '<img src="" class="rounded" alt="" style="max-height: 150px;max-width: 450px">';
                    $(img).attr("src", rst.base64).appendTo("#img-show");
                    $("input[name=thumb]").val(rst.base64);
                }).catch(function (err) {
                    /* 处理失败后执行 */
                }).always(function () {
                    /* 必然执行 */
                })
            })
        });
    </script>
@endsection