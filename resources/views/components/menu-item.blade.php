@php
    $isActive = request()->url() === $item->link;
    $hasChildren = $item->children->count() > 0;
    $location = $location ?? 'header';
@endphp

@if($location === 'footer')
    <a
        href="{{ $item->link }}"
        class="block text-sm text-gray-400 hover:text-white transition-colors {{ $isActive ? 'text-white' : '' }} {{ $item->css_class }}"
        target="{{ $item->target }}"
    >
        {{ $item->label }}
    </a>

    @if($hasChildren)
        @foreach($item->children as $child)
            @include('laraveldesign::components.menu-item', [
                'item' => $child,
                'itemClass' => $itemClass ?? '',
                'linkClass' => $linkClass ?? '',
                'activeClass' => $activeClass ?? 'active',
                'dropdownClass' => $dropdownClass ?? 'dropdown',
                'location' => $location,
            ])
        @endforeach
    @endif
@else
    <a
        href="{{ $item->link }}"
        class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors {{ $isActive ? 'text-gray-900' : '' }} {{ $item->css_class }}"
        target="{{ $item->target }}"
    >
        {{ $item->label }}
    </a>

    @if($hasChildren)
        @foreach($item->children as $child)
            @include('laraveldesign::components.menu-item', [
                'item' => $child,
                'itemClass' => $itemClass ?? '',
                'linkClass' => $linkClass ?? '',
                'activeClass' => $activeClass ?? 'active',
                'dropdownClass' => $dropdownClass ?? 'dropdown',
                'location' => $location,
            ])
        @endforeach
    @endif
@endif
