@extends(config('laraveldesign.layout', 'layouts.app'))

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description)

@section(config('laraveldesign.content_section', 'content'))
@if($page->usesBuilder())
    {{-- Page Builder Content — full width, custom CSS --}}
    @if($page->builder_data['css'] ?? null)
        @push('styles')
        <style>{!! $page->builder_data['css'] !!}</style>
        @endpush
    @endif
    <div class="laraveldesign-builder-content">
        {!! $page->builder_data['html'] ?? $page->rendered_content !!}
    </div>
@else
    {{-- Classic Editor Content --}}
    <article class="max-w-3xl mx-auto">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold leading-tight mb-6">{{ $page->title }}</h1>

        @if($page->featured_image)
            <div class="mb-8 -mx-4 sm:mx-0">
                <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}" class="w-full rounded-none sm:rounded-xl object-cover">
            </div>
        @endif

        <div class="prose prose-lg max-w-none prose-headings:font-serif prose-headings:font-bold prose-a:text-brand-600 hover:prose-a:text-brand-700 prose-img:rounded-xl">
            {!! $page->content !!}
        </div>
    </article>
@endif
@endsection
