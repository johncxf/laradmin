@extends('home.layouts.master')
@section('title', '我的资源')
@section('content')
    @include('errors.validate')
    @include('errors.message')
    <h5>上传资源</h5>
    <hr>
    <div class="">
        <form action="/resource" method="post" class="home-profile-info-form" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <a href="javascript:" class="btn btn-danger col-sm-12 home-resource-btn-upload" onclick="clickFileBtn()">
                    <i class="fa fa-cloud-upload"></i>
                    <span id="home-resource-span-file">点击上传资源</span>
                </a>
                <input type="file" name="content" class="home-resource-input-file" style="display: none">
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">资源名称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="" name="title" value="{{old('title')}}" placeholder="请输入资源名称">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="">资源类型：</label>
                <div class="col-sm-5">
                    <select class="form-control" id="" name="type">
                        <option value="">请选择</option>
                        <option value="file">文档类</option>
                        <option value="code">代码类</option>
                        <option value="picture">图片类</option>
                        <option value="default">其他</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="">所属类别：</label>
                <div class="col-sm-5">
                    <select class="form-control" id="" name="item_id">
                        <option value="0">请选择</option>
                        @foreach($items as $item)
                            <option value="{{$item['id']}}">{!! $item['_name'] !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="">资源标签：</label>
                <div class="col-sm row ml-2">
                    @foreach($tags as $tag)
                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlInline-{{$tag['id']}}" name="tag_id[]" value="{{$tag['id']}}">
                            <label class="custom-control-label" for="customControlInline-{{$tag['id']}}">{{$tag['name']}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">允许下载：</label>
                <div class="col-sm-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="status" class="custom-control-input" value="1" checked>
                        <label class="custom-control-label" for="customRadioInline1">是</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="status" class="custom-control-input" value="0">
                        <label class="custom-control-label" for="customRadioInline2">否</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">所需积分：</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="" name="gold" value="{{old('gold')}}" placeholder="1~10之间">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">资源描述：</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="" rows="3" name="remark" placeholder="详细的描述有利于提高下载量，为你获取更多积分">{{old('remark')}}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <a href="/resource" class="btn btn-primary">返回</a>
                </div>
                <div class="col-sm-8"></div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-success float-right">提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $("input.home-resource-input-file").change(function () {
                let file = $("input.home-resource-input-file").val();
                $("span#home-resource-span-file").text(file);
                $("a.home-resource-btn-upload").removeClass("btn-danger");
                $("a.home-resource-btn-upload").addClass("btn-success");
            })
        });
        function clickFileBtn() {
            $("input.home-resource-input-file").click();
        }
    </script>
@endsection