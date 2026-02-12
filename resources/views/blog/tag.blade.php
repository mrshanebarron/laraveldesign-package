@extends(config('laraveldesign.layout', 'layouts.app'))

@section('title', 'Tag: ' . $tag->name)

@section(config('laraveldesign.content_section', 'content'))
<div class="mb-10">
    <a href="{{ route('laraveldesign.blog.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-brand-600 transition-colors mb-4 group">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        All Posts
    </a>

    <div class="flex items-center gap-3 mb-2">
        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Tag
        </span>
        <h1 class="text-3xl md:text-4xl font-serif font-bold">{{ $tag->name }}</h1>
    </div>
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
                    @if($post->categories->count())
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($post->categories as $category)
                                <a href="{{ route('laraveldesign.category', $category->slug) }}" class="inline-block bg-brand-50 text-brand-700 text-xs font-medium px-2.5 py-0.5 rounded-full hover:bg-brand-100 transition-colors">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">No posts with this tag</h3>
        <p class="text-gray-500">Check back soon for new content.</p>
    </div>
@endif
@endsection
