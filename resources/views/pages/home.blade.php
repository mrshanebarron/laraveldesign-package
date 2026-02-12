@extends(config('laraveldesign.layout', 'layouts.app'))

@section('title', $page->meta_title ?: config('app.name', 'LaravelDesign'))
@section('meta_description', $page->meta_description ?: 'A WordPress-like CMS for Laravel with a visual page builder.')

@section('hero')
{{-- Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-b from-gray-950 via-gray-900 to-gray-950">
    {{-- Subtle grid pattern --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22%3E%3Cpath d=%22M0 0h60v60H0z%22 fill=%22none%22 stroke=%22%23fff%22 stroke-width=%220.5%22/%3E%3C/svg%3E'); background-size: 60px 60px;"></div>

    {{-- Accent glow --}}
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-brand-600/10 rounded-full blur-[120px]"></div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 lg:py-40">
        <div class="text-center max-w-3xl mx-auto">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 mb-8">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-sm text-gray-300 font-medium">Built for Laravel 12 + Filament 3</span>
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold text-white leading-[1.1] mb-6">
                A CMS that feels like
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-brand-300">WordPress</span>
                <br>but runs on
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-brand-300">Laravel</span>
            </h1>

            <p class="text-lg md:text-xl text-gray-400 leading-relaxed mb-10 max-w-2xl mx-auto">
                Posts, pages, categories, tags, menus, media library, visual page builder — everything you need to manage content, without leaving your Laravel application.
            </p>

            {{-- CTAs --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="https://github.com/mrshanebarron/laraveldesign" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-3.5 rounded-lg transition-all duration-200 shadow-lg shadow-brand-600/20 hover:shadow-brand-500/30 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    Get Started
                </a>
                <a href="/blog" class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 text-white font-semibold px-8 py-3.5 rounded-lg border border-white/10 hover:border-white/20 transition-all duration-200">
                    Read the Blog
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Code snippet preview --}}
        <div class="mt-16 max-w-2xl mx-auto">
            <div class="bg-gray-800/50 backdrop-blur border border-gray-700/50 rounded-xl overflow-hidden shadow-2xl">
                <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-700/50">
                    <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                    <span class="ml-2 text-xs text-gray-500 font-mono">composer require</span>
                </div>
                <div class="p-5 font-mono text-sm">
                    <p class="text-gray-500">$ composer require mrshanebarron/laraveldesign</p>
                    <p class="text-green-400 mt-2">$ php artisan laraveldesign:install</p>
                    <p class="text-gray-500 mt-2">Publishing migrations...</p>
                    <p class="text-gray-500">Running migrations...</p>
                    <p class="text-gray-500">Creating default menus...</p>
                    <p class="text-brand-400 mt-2 font-semibold">LaravelDesign installed successfully.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section(config('laraveldesign.content_section', 'content'))

{{-- Features Grid --}}
<section class="py-16 md:py-24">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-4">Everything you'd expect from a CMS</h2>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">Built natively for Laravel, not bolted on. Every feature uses Eloquent, Blade, and the patterns you already know.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Feature 1: Visual Page Builder --}}
        <div class="group relative bg-white border border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:border-gray-300 hover:-translate-y-0.5">
            <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Visual Page Builder</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Drag-and-drop editor powered by GrapesJS. Hero sections, feature grids, testimonials, pricing tables — ready to use.</p>
        </div>

        {{-- Feature 2: Blog Engine --}}
        <div class="group relative bg-white border border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:border-gray-300 hover:-translate-y-0.5">
            <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Blog Engine</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Posts, categories, tags, excerpts, featured images, reading time, SEO meta — a complete publishing system.</p>
        </div>

        {{-- Feature 3: Filament Admin --}}
        <div class="group relative bg-white border border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:border-gray-300 hover:-translate-y-0.5">
            <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Filament 3 Admin</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Beautiful admin panel with Filament. Manage posts, pages, categories, tags, menus, and media — all pre-built.</p>
        </div>

        {{-- Feature 4: Menu Management --}}
        <div class="group relative bg-white border border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:border-gray-300 hover:-translate-y-0.5">
            <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Menu Management</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Create menus for any location — header, footer, sidebar. Nested items, custom links, page links, external URLs.</p>
        </div>

        {{-- Feature 5: Media Library --}}
        <div class="group relative bg-white border border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:border-gray-300 hover:-translate-y-0.5">
            <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Media Library</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Upload images, documents, and files. Alt text, captions, file type filtering, download links — organized and searchable.</p>
        </div>

        {{-- Feature 6: SEO Ready --}}
        <div class="group relative bg-white border border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:border-gray-300 hover:-translate-y-0.5">
            <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">SEO Ready</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Meta titles, descriptions, slugs, semantic HTML, reading time — everything search engines need, built in.</p>
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="py-16 md:py-24 border-t border-gray-100">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-4">Three commands. That's it.</h2>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">Install as a Composer package. Runs alongside your existing Laravel app — no rewrites, no conflicts.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="w-12 h-12 bg-gray-950 text-white rounded-xl flex items-center justify-center mx-auto mb-4 font-serif font-bold text-lg">1</div>
            <h3 class="font-semibold mb-2">Install</h3>
            <p class="text-gray-600 text-sm">
                <code class="bg-gray-100 px-2 py-0.5 rounded text-xs font-mono">composer require mrshanebarron/laraveldesign</code>
            </p>
        </div>

        <div class="text-center">
            <div class="w-12 h-12 bg-gray-950 text-white rounded-xl flex items-center justify-center mx-auto mb-4 font-serif font-bold text-lg">2</div>
            <h3 class="font-semibold mb-2">Set Up</h3>
            <p class="text-gray-600 text-sm">
                <code class="bg-gray-100 px-2 py-0.5 rounded text-xs font-mono">php artisan laraveldesign:install</code>
            </p>
        </div>

        <div class="text-center">
            <div class="w-12 h-12 bg-gray-950 text-white rounded-xl flex items-center justify-center mx-auto mb-4 font-serif font-bold text-lg">3</div>
            <h3 class="font-semibold mb-2">Build</h3>
            <p class="text-gray-600 text-sm">Open <code class="bg-gray-100 px-2 py-0.5 rounded text-xs font-mono">/admin</code> and start creating pages</p>
        </div>
    </div>
</section>

{{-- Tech Stack --}}
<section class="py-16 md:py-24 border-t border-gray-100">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-4">Built on tools you trust</h2>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">No proprietary frameworks or vendor lock-in. Pure Laravel ecosystem.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
        <div class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all">
            <div class="text-2xl font-bold text-brand-600">L12</div>
            <span class="text-xs text-gray-500 font-medium">Laravel 12</span>
        </div>
        <div class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all">
            <div class="text-2xl font-bold text-amber-600">F3</div>
            <span class="text-xs text-gray-500 font-medium">Filament 3</span>
        </div>
        <div class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all">
            <div class="text-2xl font-bold text-pink-600">LW3</div>
            <span class="text-xs text-gray-500 font-medium">Livewire 3</span>
        </div>
        <div class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all">
            <div class="text-2xl font-bold text-purple-600">GJS</div>
            <span class="text-xs text-gray-500 font-medium">GrapesJS</span>
        </div>
        <div class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all col-span-2 md:col-span-1">
            <div class="text-2xl font-bold text-cyan-600">TW</div>
            <span class="text-xs text-gray-500 font-medium">Tailwind CSS</span>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-16 md:py-24 border-t border-gray-100">
    <div class="bg-gray-950 rounded-2xl p-8 md:p-12 lg:p-16 text-center relative overflow-hidden">
        {{-- Glow --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[400px] h-[200px] bg-brand-600/20 rounded-full blur-[80px]"></div>

        <div class="relative">
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-white mb-4">Start building today</h2>
            <p class="text-gray-400 text-lg mb-8 max-w-xl mx-auto">Add a full CMS to your Laravel app in minutes. Open source. No license fees. No limits.</p>
            <a href="https://github.com/mrshanebarron/laraveldesign" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-3.5 rounded-lg transition-all duration-200 shadow-lg shadow-brand-600/20 hover:shadow-brand-500/30 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                View on GitHub
            </a>
        </div>
    </div>
</section>

{{-- Recent Posts --}}
@php
    $recentPosts = \MrShaneBarron\LaravelDesign\Models\Post::posts()
        ->published()
        ->orderBy('published_at', 'desc')
        ->take(3)
        ->get();
@endphp

@if($recentPosts->count())
<section class="py-16 md:py-24 border-t border-gray-100">
    <div class="flex items-end justify-between mb-10">
        <div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold mb-2">Latest from the blog</h2>
            <p class="text-gray-500">Updates, tutorials, and behind the scenes.</p>
        </div>
        <a href="/blog" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors">
            All posts
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        @foreach($recentPosts as $post)
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

                    <h3 class="text-lg font-serif font-semibold mb-2 leading-snug">
                        <a href="{{ route('laraveldesign.blog.show', $post->slug) }}" class="text-gray-900 hover:text-brand-600 transition-colors">
                            {{ $post->title }}
                        </a>
                    </h3>

                    @if($post->excerpt)
                        <p class="text-gray-600 text-sm leading-relaxed mb-4 flex-1">{{ $post->excerpt }}</p>
                    @endif

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-500">{{ $post->published_at->format('M d, Y') }}</span>
                        <a href="{{ route('laraveldesign.blog.show', $post->slug) }}" class="text-xs font-medium text-brand-600 hover:text-brand-700 transition-colors">
                            Read more &rarr;
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="text-center mt-8 sm:hidden">
        <a href="/blog" class="inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors">
            View all posts
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</section>
@endif

@endsection
