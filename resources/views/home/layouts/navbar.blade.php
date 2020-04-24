<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{route('home')}}">
        <img src="{{asset('img/default/webLogo.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
        {{config('app.name')}}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">首页</a>
            </li>
            @category
                @if(isset($cate['_child']))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-{{$cate['id']}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$cate['name']}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown-{{$cate['id']}}">
                            @foreach($cate['_child'] as $first_down)
                                @if(!empty($first_down['url']))
                                    <a class="dropdown-item" href="{{$first_down['url']}}">{{$first_down['name']}}</a>
                                @else
                                    <a class="dropdown-item" href="/category/{{$first_down['alias']}}.html">{{$first_down['name']}}</a>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        @if(!empty($cate['url']))
                            <a class="nav-link" href="{{$cate['url']}}">{{$cate['name']}}</a>
                        @else
                            <a class="nav-link" href="/category/{{$cate['alias']}}.html">{{$cate['name']}}</a>
                        @endif
                    </li>
                @endif
            @endCategory
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="/search">
            @csrf
            <input class="form-control mr-sm-2" name="keyword" type="search" value="" placeholder="请输入资源信息" aria-label="Search">
        </form>
        @guest
            <div class="nav-item">
                <a class="btn text-success" href="/login">登录</a>
                <span class="text-muted">|</span>
                <a class="btn text-danger" href="/register">注册</a>
            </div>
        @endguest
        @auth
            <ul class="navbar-nav">
                <li class="dropdown user user-menu open">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <img class="user-image user-avatar" src="{{asset(auth()->user()->avatar?auth()->user()->avatar:'img/default/avatar.jpg')}}" alt="">
                        <span class="hidden-xs">{{auth()->user()->username}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="user-header bg-light">
                            <img src="{{asset(auth()->user()->avatar?auth()->user()->avatar:'img/default/avatar.jpg')}}" class="img-circle user-avatar" alt="">
                            <p>
                                {{auth()->user()->last_login_time}}
                                <small></small>
                            </p>
                        </li>
                        <li class="user-body">
                            <div class="row">
                                <div class="text-center col-sm-6">
                                    <a href="/profile/index">个人主页</a>
                                </div>
                                <div class="text-center col-sm-6">
                                    <a href="/resource">上传资源</a>
                                </div>
                            </div>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/profile/site" class="btn btn-outline-primary btn-flat">账号设置</a>
                            </div>
                            <div class="pull-right">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">退出登录</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        @endauth
    </div>
</nav>