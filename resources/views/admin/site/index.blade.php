@extends('admin.layouts.app')
@section('title', '系统配置')
@section('content')
    <div class="row">
        @component('admin.component.tab')
            @slot('nav')
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-site-index-tab" data-toggle="pill" href="#custom-tabs-site-index" role="tab" aria-controls="custom-tabs-site-index" aria-selected="true">
                        系统配置
                    </a>
                </li>
            @endslot
            @slot('body')
                <div class="tab-pane fade active show" id="custom-tabs-site-index" role="tabpanel" aria-labelledby="custom-tabs-site-index-tab">
                    <form action="/admin/site/set" method="POST" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-1 col-form-label">站点名称</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="" name="sitename" value="{{$siteName->value}}">
                                </div>
                                <span class="col-sm-6 text-gray">{{$siteName->tip}}</span>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-1 col-form-label">备案号</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="" placeholder="" name="beian" value="{{$beiAn->value}}">
                                </div>
                                <span class="col-sm-6 text-gray">{{$beiAn->tip}}</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">保存</button>
                        </div>
                    </form>
                </div>
            @endslot
        @endcomponent
    </div>
@endsection