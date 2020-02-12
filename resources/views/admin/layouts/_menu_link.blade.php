<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/admin/index" class="nav-link" data-menu-level="0">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    控制台
                    <span class="right badge badge-danger">Hot</span>
                </p>
            </a>
        </li>
        @foreach($webSiteInfo->getMenus() as $first_menu)
        <li class="nav-header">{{$first_menu['name']}}</li>
            @isset($first_menu['_child'])
                @foreach($first_menu['_child'] as $second_menu)
                    @if(isset($second_menu['_child']))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon {{$second_menu['icon']}}"></i>
                                <p>
                                    {{$second_menu['name']}}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            @foreach($second_menu['_child'] as $third_menu)
                                <ul class="nav nav-treeview">
                                    @if(isset($third_menu['_child']))
                                        <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon {{$third_menu['icon']}}"></i>
                                                <p>
                                                    {{$third_menu['name']}}
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>
                                            @foreach($third_menu['_child'] as $fourth_menu)
                                                <ul class="nav nav-treeview">
                                                    <li class="nav-item">
                                                        <a href="{{$fourth_menu['url']}}" class="nav-link" data-menu-level="3" pjax>
                                                            <i class="nav-icon {{$fourth_menu['icon']}}"></i>
                                                            <p>{{$fourth_menu['name']}}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a href="{{$third_menu['url']}}" class="nav-link" data-menu-level="2" pjax>
                                                <i class="nav-icon {{$third_menu['icon']}}"></i>
                                                <p>{{$third_menu['name']}}</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @endforeach
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{$second_menu['url']}}" class="nav-link" data-menu-level="1">
                                <i class="nav-icon {{$second_menu['icon']}}"></i>
                                <p>{{$second_menu['name']}}</p>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endisset
        @endforeach
        @if(config('website.menu_link.status') == 1)
            <li class="nav-header">{{config('website.menu_link.title')}}</li>
            @foreach(config('website.menu_link.links') as $link)
                <li class="nav-item">
                    <a href="{{$link['url']}}" class="nav-link" target="_blank">
                        <i class="nav-icon far {{$link['icon']}}"></i>
                        <p class="text">{{$link['name']}}</p>
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</nav>
<!-- /.sidebar-menu -->