@props(['active' => false, 'route' => '', 'name' => '', 'show' => true])
@if($show)
    <li class="{{ $active ? ' current-page' : '' }}">
        <a href="{{ $route }}">{{ $name }}</a>
    </li>
@endif