<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: {{ $page->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if($page->builder_data['css'] ?? null)
        <style>{!! $page->builder_data['css'] !!}</style>
    @endif
    <style>
        /* Preview bar */
        .ld-preview-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #1f2937;
            color: white;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 9999;
            font-family: system-ui, sans-serif;
        }
        .ld-preview-bar a {
            color: #60a5fa;
            text-decoration: none;
        }
        .ld-preview-bar a:hover {
            text-decoration: underline;
        }
        .ld-preview-content {
            padding-top: 48px;
        }
    </style>
</head>
<body>
    <div class="ld-preview-bar">
        <div class="flex items-center gap-4">
            <span class="font-semibold">Preview Mode</span>
            <span class="text-gray-400">|</span>
            <span>{{ $page->title }}</span>
            @if($page->status !== 'published')
                <span class="bg-amber-500 text-black text-xs px-2 py-1 rounded">{{ ucfirst($page->status) }}</span>
            @endif
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('filament.admin.pages.page-builder', ['post_id' => $page->id]) }}">← Back to Editor</a>
            <span class="text-gray-400">|</span>
            <button onclick="window.close()" class="text-gray-400 hover:text-white">Close Preview</button>
        </div>
    </div>

    <div class="ld-preview-content">
        @if($page->usesBuilder())
            {!! $page->builder_data['html'] ?? '' !!}
        @else
            <div class="max-w-4xl mx-auto py-12 px-4">
                <h1 class="text-4xl font-bold mb-6">{{ $page->title }}</h1>
                @if($page->featured_image)
                    <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}" class="w-full rounded-lg mb-8">
                @endif
                <div class="prose prose-lg max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        @endif
    </div>
</body>
</html>
