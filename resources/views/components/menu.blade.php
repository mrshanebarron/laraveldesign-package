@props([
    'location' => null,
    'menu' => null,
    'class' => '',
    'itemClass' => '',
    'linkClass' => '',
    'activeClass' => 'active',
    'dropdownClass' => 'dropdown',
    'tag' => 'nav',
])

@php
    use MrShaneBarron\LaravelDesign\Models\Menu;

    if (!$menu && $location) {
        $menu = Menu::getByLocation($location);
    }
@endphp

@if($menu)
    <{{ $tag }} @class(['ld-menu', $class]) @if($location) data-menu-location="{{ $location }}" @endif>
        @foreach($menu->items as $item)
            @include('laraveldesign::components.menu-item', [
                'item' => $item,
                'itemClass' => $itemClass,
                'linkClass' => $linkClass,
                'activeClass' => $activeClass,
                'dropdownClass' => $dropdownClass,
                'location' => $location,
            ])
        @endforeach
    </{{ $tag }}>
@endif
