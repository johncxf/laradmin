<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/index" class="brand-link">
        <img src="{{asset(config('website.webLogo'))}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">后台管理中心</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset(auth('admin')->user()['avatar']?auth('admin')->user()['avatar']:'img/default/avatar.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="/admin/person/index" class="d-block">{{auth('admin')->user()['username']}}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        @if(config('website.menu_template'))
            @include('admin.layouts.'.config('website.menu_template'))
        @else
            @include('admin.layouts._menu')
        @endif
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
