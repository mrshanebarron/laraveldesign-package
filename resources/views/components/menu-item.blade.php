@php
    $isActive = request()->url() === $item->link;
    $hasChildren = $item->children->count() > 0;
    $location = $location ?? null;
    $itemClass = $itemClass ?? '';
    $linkClass = $linkClass ?? '';
    $activeClass = $activeClass ?? 'active';
    $dropdownClass = $dropdownClass ?? 'dropdown';
@endphp

<span @class(['ld-menu-item', $itemClass, $dropdownClass => $hasChildren])>
    <a
        href="{{ $item->link }}"
        @class([
            'ld-menu-link',
            $linkClass,
            $activeClass => $isActive,
            $item->css_class => $item->css_class,
        ])
        target="{{ $item->target ?? '_self' }}"
    >
        {{ $item->label }}
    </a>

    @if($hasChildren)
        @foreach($item->children as $child)
            @include('laraveldesign::components.menu-item', [
                'item' => $child,
                'itemClass' => $itemClass,
                'linkClass' => $linkClass,
                'activeClass' => $activeClass,
                'dropdownClass' => $dropdownClass,
                'location' => $location,
            ])
        @endforeach
    @endif
</span>
