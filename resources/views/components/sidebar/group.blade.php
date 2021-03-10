@props(['name', 'icon' => '', 'active' => false, 'show' => true, 'group' => false, 'route' => ''])
@if($show)
    <li class="{{ $active ? ' active': '' }}">

        @if($group)
            <a>
                <i class="{!! $icon !!}"></i>{{ $name }} <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
                {{ $slot }}
            </ul>
        @else
            <a href="{{ $route }}">
                <i class="{!! $icon !!}"></i>{{ $name }}
            </a>
        @endif
    </li>
@endif
