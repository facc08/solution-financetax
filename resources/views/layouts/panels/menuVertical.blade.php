@can($menu->can)
<li class="dropdown {{ ActiveAll($menu->submenu)}}">
    <a href="#{{ $menu->url}}" class="nav-link has-dropdown" aria-expanded="{{ expanded($menu->submenu) }}">
        <i data-feather="{{ $menu->icon }}"></i><span>{{ $menu->name }}</span>
    </a>
    @if ($menu->name == "Servicios")
        <ul class="dropdown-menu {{submenu($menu->submenu)}}" id="{{$menu->url}}" style="display: block;">
    @else
        <ul class="dropdown-menu {{submenu($menu->submenu)}}" id="{{$menu->url}}">
    @endif
        @foreach ($menu->submenu as $submenu)
            @if ($submenu->can)
                @if(isset($submenu->submenunieto))
                    <a href="#{{ $submenu->url}}" class="nav-link has-dropdown" aria-expanded="{{ expanded($submenu->submenunieto) }}">
                        <i data-feather="{{ $submenu->icon }}"></i><span>{{ $submenu->name }}</span></a>
                    <ul class="dropdown-menu {{submenunieto($submenu->submenunieto)}}" id="{{$submenu->url}}" style="display: block;">
                    @foreach ($submenu->submenunieto as $submenunieto)
                        <li class="{{active($submenunieto->url)}}">
                            <a class="nav-link" href="{{$submenunieto->url}}"><i class="{{$submenunieto->icon}}" aria-hidden="true"></i>&nbsp;{{$submenunieto->name}}</a>
                        </li>
                    @endforeach
                    </ul>
                @else
                    @can($submenu->can)
                    <li class="{{active($submenu->url)}}">
                    <a class="nav-link" href="{{ route($submenu->route)}}">{{$submenu->name}}</a>
                    </li>
                    @endcan
                @endif
            @else
                <li class="{{active($submenu->url)}}">
                    <a class="nav-link" href="{{ route($submenu->route)}}">{{$submenu->name}}</a>
                </li>
            @endif
        @endforeach
    </ul>
</li>
@endcan