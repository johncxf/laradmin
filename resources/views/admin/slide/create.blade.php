@extends('admin.layouts.app')
@section('title', '添加栏目')
@section('content')
    @component('admin.component.tab')
        @slot('nav')
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-index-tab" href="/admin/slide" role="tab" aria-controls="custom-tabs-index" aria-selected="true">
                    幻灯片列表
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-create-tab" data-toggle="pill" href="#custom-tabs-create" role="tab" aria-controls="custom-tabs-create" aria-selected="false">
                    添加幻灯片
                </a>
            </li>
        @endslot
        @slot('body')
            <div class="tab-pane fade active show" id="custom-tabs-create" role="tabpanel" aria-labelledby="custom-tabs-create-tab">
                @component('admin.component.form', ['url' => '/admin/slide'])
                    @slot('form_body')
                        <input type="hidden" name="content">
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">名称</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" name="name" value="{{old('name')}}">
                            </div>
                            <span class="col-sm-5 text-danger">*</span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">图片</label>
                            <div class="col-sm-5">
                                <input type="file" accept="image/jpeg" capture="camera">
                            </div>
                        </div>
                        <div class="col-sm-6 row mb-3">
                            <div class="col-sm-2"></div>
                            <div class="col-sm ml-2" id="img-show"></div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">类型</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="status">
                                    <option selected="selected" value="home">前台首页</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">状态</label>
                            <div class="col-sm-5">
                                <select class="custom-select" name="status">
                                    <option selected="selected" value="1">显示</option>
                                    <option value="0">隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-1 col-form-label">排序</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="" placeholder="" name="sort" value="0">
                            </div>
                        </div>
                    @endslot
                    @slot('form_footer')
                        <button type="submit" class="btn btn-info">保存</button>
                        <a href="/admin/slide" class="btn btn-default float-right">返回</a>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent
@endsection
@section('scripts')
    <script src="{{asset('plugins/lrz/lrz.bundle.js')}}"></script>
    <script>
        $(function () {
            $("input[type=file]").change(function () {
                $("img").remove();
                /* 压缩图片 */
                lrz(this.files[0], {
                    //
                }).then(function (rst) {
                    /* 处理成功后执行 */
                    rst.formData.append('base64img', rst.base64); // 添加额外参数
                    img = '<img src="" class="rounded" alt="" style="max-height: 150px;max-width: 450px">';
                    $(img).attr("src", rst.base64).appendTo("#img-show");
                    $("input[name=content]").val(rst.base64);
                }).catch(function (err) {
                    /* 处理失败后执行 */
                }).always(function () {
                    /* 必然执行 */
                })
            })
        });
    </script>
@endsection