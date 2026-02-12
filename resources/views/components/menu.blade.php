@props([
    'location' => null,
    'menu' => null,
    'class' => '',
    'itemClass' => '',
    'linkClass' => '',
    'activeClass' => 'active',
    'dropdownClass' => 'dropdown',
])

@php
    use MrShaneBarron\LaravelDesign\Models\Menu;

    if (!$menu && $location) {
        $menu = Menu::getByLocation($location);
    }
@endphp

@if($menu)
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
@endif
