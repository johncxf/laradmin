<ul class="nav flex-column">
    @menu
    <li>
        <a class="nav-link text-dark" href="{{$field['url']}}">
            <i class="{{$field['icon']}}"></i>
            <span class="ml-2">{{$field['name']}}</span>
            <i class="fa fa-angle-right float-right text-muted"></i>
        </a>
    </li>
    @endMenu
</ul>