@extends('home.layouts.master')
@section('title', '我的资源')
@section('content')
    @include('errors.validate')
    @include('errors.message')
    <h5>修改资源信息</h5>
    <hr>
    <div class="">
        <form action="/resource/{{$resource['id']}}" method="post" class="home-profile-info-form" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">资源名称：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="" name="title" value="{{$resource['title']}}" placeholder="请输入资源名称">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="">资源类型：</label>
                <div class="col-sm-5">
                    <select class="form-control" id="" name="type">
                        <option value="">请选择</option>
                        <option value="file" {{$resource['type']=='file'?'selected':''}}>文档类</option>
                        <option value="picture" {{$resource['type']=='code'?'selected':''}}>代码类</option>
                        <option value="code" {{$resource['type']=='picture'?'selected':''}}>图片类</option>
                        <option value="default" {{$resource['type']=='default'?'selected':''}}>其他</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="">所属类别：</label>
                <div class="col-sm-5">
                    <select class="form-control" id="" name="item_id">
                        <option value="0">请选择</option>
                        @foreach($items as $item)
                            <option value="{{$item['id']}}" {{$resource['item_id']==$item['id']?'selected':''}}>{!! $item['_name'] !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="">资源标签：</label>
                <div class="col-sm row ml-2">
                    @foreach($tags as $tag)
                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlInline-{{$tag['id']}}" name="tag_id[]"
                                   value="{{$tag['id']}}" {{in_array($tag['id'],$tag_ids)?'checked':''}}>
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
                    <input type="text" class="form-control" id="" name="gold" value="{{$resource['gold']}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">资源描述：</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="" rows="3" name="remark">{{$resource['remark']}}</textarea>
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