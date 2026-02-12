@extends(config('laraveldesign.layout', 'layouts.app'))

@section('title', $post->meta_title ?: $post->title)
@section('meta_description', $post->meta_description ?: $post->excerpt)

@section(config('laraveldesign.content_section', 'content'))
<article class="max-w-3xl mx-auto">
    {{-- Back link --}}
    <a href="{{ route('laraveldesign.blog.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-brand-600 transition-colors mb-8 group">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Blog
    </a>

    {{-- Header --}}
    <header class="mb-8">
        @if($post->categories->count())
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($post->categories as $category)
                    <a href="{{ route('laraveldesign.category', $category->slug) }}" class="inline-block bg-brand-50 text-brand-700 text-xs font-medium px-3 py-1 rounded-full hover:bg-brand-100 transition-colors">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold leading-tight mb-4">{{ $post->title }}</h1>

        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
            <time datetime="{{ $post->published_at->toIso8601String() }}">
                {{ $post->published_at->format('F d, Y') }}
            </time>
            @if($post->author)
                <span class="text-gray-300">&middot;</span>
                <span>by <span class="text-gray-700 font-medium">{{ $post->author->name }}</span></span>
            @endif
            <span class="text-gray-300">&middot;</span>
            <span>{{ $post->reading_time }} min read</span>
        </div>
    </header>

    {{-- Featured Image --}}
    @if($post->featured_image)
        <div class="mb-10 -mx-4 sm:mx-0">
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full rounded-none sm:rounded-xl object-cover max-h-[480px]">
        </div>
    @endif

    {{-- Content --}}
    <div class="prose prose-lg max-w-none prose-headings:font-serif prose-headings:font-bold prose-a:text-brand-600 hover:prose-a:text-brand-700 prose-img:rounded-xl prose-blockquote:border-brand-300 prose-blockquote:bg-gray-50 prose-blockquote:py-1 prose-blockquote:px-6 prose-blockquote:rounded-r-lg">
        {!! $post->content !!}
    </div>

    {{-- Tags --}}
    @if($post->tags->count())
        <footer class="mt-10 pt-8 border-t border-gray-200">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-gray-500 mr-1">Tags:</span>
                @foreach($post->tags as $tag)
                    <a href="{{ route('laraveldesign.tag', $tag->slug) }}" class="inline-block bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full hover:bg-gray-200 hover:text-gray-800 transition-colors">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </footer>
    @endif

    {{-- Post Navigation --}}
    <div class="mt-12 pt-8 border-t border-gray-200">
        <a href="{{ route('laraveldesign.blog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            All Posts
        </a>
    </div>
</article>
@endsection
