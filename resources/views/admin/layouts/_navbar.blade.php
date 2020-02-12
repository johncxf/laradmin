<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/index" class="nav-link">控制台</a>
        </li>
    </ul>

    <!-- 全局搜索框 -->
    <form class="form-inline ml-3" action="" method="post">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="搜索菜单" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- 首页 -->
        <li class="nav-item">
            <a class="nav-link" href="/" target="_blank">
                <i class="fas fa-home"></i>
            </a>
        </li>
        <!-- 用户信息下拉框 -->
        <li class="dropdown user user-menu open">
            <a href="#" class="nav-link" data-toggle="dropdown">
                <img src="{{asset(auth('admin')->user()['avatar']?auth('admin')->user()['avatar']:'img/default/avatar.jpg')}}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{auth('admin')->user()['username']}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-gray">
                    <img src="{{asset(auth('admin')->user()['avatar']?auth('admin')->user()['avatar']:'img/default/avatar.jpg')}}" class="img-circle" alt="User Image">
                    <p>
                        {{auth('admin')->user()['username']}}
                        <small>{{auth('admin')->user()['login_time']}}</small>
                    </p>
                </li>
                <li class="user-body">
                    <div class="row">
                        <div class="text-center col-sm-4">
                            <a href="/" target="_blank">Laradmin</a>
                        </div>
                        <div class="text-center col-sm-4">
                            <a href="#">Sales</a>
                        </div>
                        <div class="text-center col-sm-4">
                            <a href="#">Friends</a>
                        </div>
                    </div>
                </li>
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="/admin/person/index" class="btn btn-secondary btn-flat">个人信息</a>
                    </div>
                    <div class="pull-right">
                        <a href="/admin/logout" class="btn btn-danger btn-flat">退出登录</a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- 右侧控制栏 -->
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
