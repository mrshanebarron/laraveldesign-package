@extends(config('laraveldesign.layout', 'layouts.app'))

@section('title', 'Category: ' . $category->name)

@section(config('laraveldesign.content_section', 'content'))
<div class="mb-10">
    <a href="{{ route('laraveldesign.blog.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-brand-600 transition-colors mb-4 group">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        All Posts
    </a>

    <div class="flex items-center gap-3 mb-2">
        <span class="inline-block bg-brand-50 text-brand-700 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">Category</span>
        <h1 class="text-3xl md:text-4xl font-serif font-bold">{{ $category->name }}</h1>
    </div>

    @if($category->description)
        <p class="text-lg text-gray-500 mt-2 max-w-2xl">{{ $category->description }}</p>
    @endif
</div>

@if($posts->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($posts as $post)
            <article class="bg-white border border-gray-200 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-gray-300 hover:-translate-y-0.5 flex flex-col">
                @if($post->featured_image)
                    <a href="{{ route('laraveldesign.blog.show', $post->slug) }}" class="block">
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    </a>
                @endif

                <div class="p-6 flex flex-col flex-1">
                    <h2 class="text-lg font-serif font-semibold mb-2 leading-snug">
                        <a href="{{ route('laraveldesign.blog.show', $post->slug) }}" class="text-gray-900 hover:text-brand-600 transition-colors">
                            {{ $post->title }}
                        </a>
                    </h2>

                    @if($post->excerpt)
                        <p class="text-gray-600 text-sm leading-relaxed mb-4 flex-1">{{ $post->excerpt }}</p>
                    @endif

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                            <span class="text-gray-300">&middot;</span>
                            <span>{{ $post->reading_time }} min read</span>
                        </div>
                        <a href="{{ route('laraveldesign.blog.show', $post->slug) }}" class="text-xs font-medium text-brand-600 hover:text-brand-700 transition-colors">
                            Read more &rarr;
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $posts->links() }}
    </div>
@else
    <div class="text-center py-16">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">No posts in this category</h3>
        <p class="text-gray-500">Check back soon for new content.</p>
    </div>
@endif
@endsection
