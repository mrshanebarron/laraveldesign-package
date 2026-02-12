@props([
    'showCount' => true,
    'class' => '',
])

@php
    use MrShaneBarron\LaravelDesign\Models\Category;

    $categories = Category::root()
        ->withCount(['posts' => function ($query) {
            $query->published();
        }])
        ->orderBy('name')
        ->get();
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    <ul class="space-y-2">
        @foreach($categories as $category)
            <li>
                <a href="{{ route('laraveldesign.category', $category->slug) }}" class="flex items-center justify-between text-sm text-gray-700 hover:text-brand-600 transition-colors group">
                    <span class="group-hover:translate-x-0.5 transition-transform">{{ $category->name }}</span>
                    @if($showCount)
                        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $category->posts_count }}</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>
