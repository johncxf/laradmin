@extends('home.layouts.app')
@section('title', $article->title)
@section('content')
    <div class="row col-sm-12 mt-2">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div class="container">
                <div class="card">
                    <h5 class="card-header">{{$article->title}}</h5>
                    <div class="card-body">
                        {!! $article->content !!}
                        <a href="/article/star/{{$article->id}}" class="btn btn-default btn-sm">
                            @if($article->is_star)
                                <i class="fa fa-star"></i> 已收藏
                            @else
                                <i class="fa fa-star-o"></i> 收藏
                            @endif
                        </a>
                        <a href="/article/praise/{{$article->id}}" class="btn btn-default btn-sm">
                            @if($article->is_praise)
                                <i class="fa fa-thumbs-up"></i> 已点赞
                            @else
                                <i class="fa fa-thumbs-o-up"></i> 点赞
                            @endif
                        </a>
                        <span class="float-right text-muted">{{$article->star}} 收藏 - {{$article->praise}} 点赞 - {{$article->comments}} 评论</span>
                    </div>
                    <div class="card-footer">
                        @include('errors.validate')
                        @include('errors.message')
                        @foreach($comments as $comment)
                            <div class="card-comment">
                                <img class="img-circle img-sm" src="{{asset($comment['cavatar']?$comment['cavatar']:'img/default/avatar.jpg')}}" alt="User Image">
                                <div class="comment-text">
                                    <span class="ml-2 text-primary">
                                        {{$comment['cname']}}
                                        <span class="text-muted float-right">{{$comment['create_at']}}</span>
                                    </span>
                                    <div class="col-sm-12 row">
                                        <div class="col-sm-11 ml-2">
                                            <p>&nbsp;&nbsp;{{$comment['content']}}</p>
                                        </div>
                                        <button type="button" class="btn btn-default btn-sm float-right" onclick="reply({{$comment['id']}})"><i class="fa fa-comment-o"></i> 回复</button>
                                        <form action="/comment/reply" method="post" class="col-sm-12 mb-2 mt-2 ml-2" id="form-comment-{{$comment['id']}}" style="display:none;">
                                            @csrf
                                            <input type="hidden" name="article_id" value="{{$article->id}}">
                                            <input type="hidden" name="pid" value="{{$comment['id']}}">
                                            <input type="hidden" name="target_id" value="{{$comment['uid']}}">
                                            <div class="img-push">
                                                <input type="text" name="content" class="form-control form-control-sm" placeholder="请输入评论内容...">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @isset($comment['_child'])
                                @foreach($comment['_child'] as $child)
                                    <div class="card-comment ml-4">
                                        <img class="img-circle img-sm" src="{{asset($child['cavatar']?$child['cavatar']:'img/default/avatar.jpg')}}" alt="User Image">
                                        <div class="comment-text">
                                            <span class="ml-2 text-info">
                                                {{$child['cname']}}：
                                                @<span>{{$child['tname']}}</span>
                                                <span class="text-muted float-right">{{$child['create_at']}}</span>
                                            </span>
                                            <div class="col-sm-12 row">
                                                <div class="col-sm-11 ml-2">
                                                    <p class="ml-4">&nbsp;&nbsp;{{$child['content']}}</p>
                                                </div>
                                                <button type="button" class="btn btn-default btn-sm float-right" onclick="reply({{$child['id']}})"><i class="fa fa-comment-o"></i> 回复</button>
                                                <form action="/comment/reply" method="post" class="col-sm-12 mb-2 mt-2 ml-2" id="form-comment-{{$child['id']}}" style="display:none;">
                                                    @csrf
                                                    <input type="hidden" name="article_id" value="{{$article->id}}">
                                                    <input type="hidden" name="pid" value="{{$child['id']}}">
                                                    <input type="hidden" name="target_id" value="{{$child['uid']}}">
                                                    <div class="img-push">
                                                        <input type="text" name="content" class="form-control form-control-sm" placeholder="请输入评论内容...">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
                        @endforeach
                        <form action="/comment/store" method="post" class="comment-form">
                            @csrf
                            <input type="hidden" name="article_id" value="{{$article->id}}">
                            @if(auth()->id() !== null)
                                <img class="img-fluid img-circle img-sm" src="{{asset(auth()->user()['avatar']?auth()->user()['avatar']:'img/default/avatar.jpg')}}" alt="Alt Text">
                            @endisset
                            <div class="img-push">
                                <input type="text" name="content" class="form-control form-control-sm" placeholder="请输入评论内容...">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            @include('home.component.sidebar')
            @link(['limit' => 5])
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function reply(cid) {
            let form = $("#form-comment-"+cid);
            form.toggle();
        }
    </script>
@endsection