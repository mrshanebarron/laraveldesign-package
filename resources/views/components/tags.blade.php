@props([
    'class' => '',
])

@php
    use MrShaneBarron\LaravelDesign\Models\Tag;

    $tags = Tag::withCount(['posts' => function ($query) {
            $query->published();
        }])
        ->having('posts_count', '>', 0)
        ->orderBy('name')
        ->get();
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-wrap gap-2 ' . $class]) }}>
    @foreach($tags as $tag)
        <a href="{{ route('laraveldesign.tag', $tag->slug) }}" class="inline-block bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full hover:bg-gray-200 hover:text-gray-800 transition-colors">
            {{ $tag->name }}
        </a>
    @endforeach
</div>
