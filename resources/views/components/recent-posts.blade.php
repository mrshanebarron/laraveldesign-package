@props([
    'limit' => 5,
    'class' => '',
])

@php
    use MrShaneBarron\LaravelDesign\Models\Post;

    $posts = Post::posts()
        ->published()
        ->orderBy('published_at', 'desc')
        ->take($limit)
        ->get();
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    <ul class="space-y-3">
        @foreach($posts as $post)
            <li class="flex flex-col gap-0.5">
                <a href="{{ route('laraveldesign.blog.show', $post->slug) }}" class="text-sm font-medium text-gray-900 hover:text-brand-600 transition-colors leading-snug">
                    {{ $post->title }}
                </a>
                <span class="text-xs text-gray-500">
                    {{ $post->published_at->format('M d, Y') }}
                </span>
            </li>
        @endforeach
    </ul>
</div>
