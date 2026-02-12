<div class="ld-page-builder-wrapper">
    {{-- GrapesJS CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/grapesjs@0.21.10/dist/css/grapes.min.css">
    <style>
        /* Override GrapesJS styles for better integration */
        .gjs-one-bg { background-color: #1f2937; }
        .gjs-two-color { color: #9ca3af; }
        .gjs-three-bg { background-color: #374151; }
        .gjs-four-color, .gjs-four-color-h:hover { color: #3b82f6; }

        .gjs-block {
            width: 100%;
            min-height: 60px;
            margin-bottom: 8px;
        }

        .gjs-block__media {
            height: 40px;
        }

        .gjs-block-label {
            font-size: 11px;
        }

        #ld-editor .gjs-frame-wrapper {
            background: white;
        }

        /* Category headers */
        .gjs-block-category .gjs-title {
            background: #e5e7eb;
            font-weight: 600;
            padding: 8px 12px;
        }

        /* Selected component highlight */
        .gjs-selected {
            outline: 2px solid #3b82f6 !important;
            outline-offset: -2px;
        }

        /* Rich text editor styling */
        .gjs-rte-toolbar {
            background: #1f2937;
            border-radius: 4px;
        }

        .gjs-rte-action {
            color: white;
        }
    </style>

    <div class="ld-page-builder h-screen flex flex-col" wire:ignore>
        {{-- Toolbar --}}
        <div class="bg-gray-900 text-white px-4 py-2 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="font-semibold">Page Builder</span>
            <div class="flex gap-2">
                <button id="ld-device-desktop" class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600" title="Desktop">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </button>
                <button id="ld-device-tablet" class="px-3 py-1 rounded hover:bg-gray-600" title="Tablet">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </button>
                <button id="ld-device-mobile" class="px-3 py-1 rounded hover:bg-gray-600" title="Mobile">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </button>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button id="ld-undo" class="px-3 py-1 rounded hover:bg-gray-600" title="Undo">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
            </button>
            <button id="ld-redo" class="px-3 py-1 rounded hover:bg-gray-600" title="Redo">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"/></svg>
            </button>
            <button id="ld-preview" class="px-4 py-1 rounded bg-gray-700 hover:bg-gray-600">
                Preview
            </button>
            <button id="ld-save" class="px-4 py-1 rounded bg-blue-600 hover:bg-blue-700 font-medium">
                Save
            </button>
        </div>
    </div>

    {{-- Main Editor Area --}}
    <div class="flex-1 flex overflow-hidden">
        {{-- Blocks Panel --}}
        <div class="w-64 bg-gray-100 border-r overflow-y-auto">
            <div class="p-4">
                <h3 class="font-semibold text-gray-700 mb-3">Blocks</h3>
                <div id="ld-blocks-container"></div>
            </div>
        </div>

        {{-- Canvas --}}
        <div class="flex-1 bg-gray-200 overflow-auto">
            <div id="ld-editor" class="h-full"></div>
        </div>

        {{-- Styles Panel --}}
        <div class="w-72 bg-white border-l overflow-y-auto">
            <div id="ld-styles-container" class="p-4"></div>
            <div id="ld-traits-container" class="p-4 border-t"></div>
            <div id="ld-layers-container" class="p-4 border-t"></div>
        </div>
    </div>
</div>

{{-- GrapesJS JS --}}
<script src="https://unpkg.com/grapesjs@0.21.10/dist/grapes.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Block definitions from PHP
    const blockTypes = @json($blockTypes);

    // Initialize GrapesJS
    const editor = grapesjs.init({
        container: '#ld-editor',
        fromElement: false,
        height: '100%',
        width: 'auto',
        storageManager: false,
        panels: { defaults: [] },
        blockManager: {
            appendTo: '#ld-blocks-container',
        },
        styleManager: {
            appendTo: '#ld-styles-container',
            sectors: [
                {
                    name: 'Dimension',
                    open: false,
                    properties: [
                        'width', 'height', 'max-width', 'min-height', 'margin', 'padding'
                    ],
                },
                {
                    name: 'Typography',
                    open: false,
                    properties: [
                        'font-family', 'font-size', 'font-weight', 'letter-spacing',
                        'color', 'line-height', 'text-align', 'text-decoration', 'text-transform'
                    ],
                },
                {
                    name: 'Background',
                    open: false,
                    properties: [
                        'background-color', 'background-image', 'background-repeat',
                        'background-position', 'background-size'
                    ],
                },
                {
                    name: 'Border',
                    open: false,
                    properties: [
                        'border-radius', 'border', 'box-shadow'
                    ],
                },
                {
                    name: 'Layout',
                    open: false,
                    properties: [
                        'display', 'flex-direction', 'justify-content', 'align-items', 'gap'
                    ],
                },
            ],
        },
        traitManager: {
            appendTo: '#ld-traits-container',
        },
        layerManager: {
            appendTo: '#ld-layers-container',
        },
        canvas: {
            styles: [
                'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css',
            ],
        },
        plugins: [],
        pluginsOpts: {},
    });

    // Add custom blocks
    const blockManager = editor.BlockManager;

    blockTypes.forEach(block => {
        blockManager.add(block.id, {
            label: block.label,
            category: block.category,
            content: block.content,
            media: block.media,
        });
    });

    // Add basic blocks
    blockManager.add('text', {
        label: 'Text',
        category: 'Basic',
        content: '<p class="p-4">Insert your text here</p>',
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 5h18v2H3V5zm0 6h18v2H3v-2zm0 6h12v2H3v-2z"/></svg>',
    });

    blockManager.add('image', {
        label: 'Image',
        category: 'Basic',
        select: true,
        content: { type: 'image' },
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>',
    });

    blockManager.add('link', {
        label: 'Link',
        category: 'Basic',
        content: '<a href="#" class="text-blue-600 hover:underline">Click here</a>',
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>',
    });

    blockManager.add('button', {
        label: 'Button',
        category: 'Basic',
        content: '<a href="#" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Button</a>',
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="8" width="16" height="8" rx="2" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
    });

    blockManager.add('divider', {
        label: 'Divider',
        category: 'Basic',
        content: '<hr class="my-8 border-gray-300">',
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><line x1="4" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2"/></svg>',
    });

    blockManager.add('spacer', {
        label: 'Spacer',
        category: 'Basic',
        content: '<div class="h-16"></div>',
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="8" y="4" width="8" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="4"/></svg>',
    });

    blockManager.add('video', {
        label: 'Video',
        category: 'Media',
        select: true,
        content: { type: 'video', src: '', controls: true },
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>',
    });

    blockManager.add('columns-2', {
        label: '2 Columns',
        category: 'Layout',
        content: '<div class="grid grid-cols-2 gap-4 p-4"><div class="bg-gray-100 p-4 min-h-[100px]">Column 1</div><div class="bg-gray-100 p-4 min-h-[100px]">Column 2</div></div>',
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="4" width="9" height="16" fill="none" stroke="currentColor" stroke-width="2"/><rect x="13" y="4" width="9" height="16" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
    });

    blockManager.add('columns-3', {
        label: '3 Columns',
        category: 'Layout',
        content: '<div class="grid grid-cols-3 gap-4 p-4"><div class="bg-gray-100 p-4 min-h-[100px]">Column 1</div><div class="bg-gray-100 p-4 min-h-[100px]">Column 2</div><div class="bg-gray-100 p-4 min-h-[100px]">Column 3</div></div>',
        media: '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="4" width="5.5" height="16" fill="none" stroke="currentColor" stroke-width="2"/><rect x="9.25" y="4" width="5.5" height="16" fill="none" stroke="currentColor" stroke-width="2"/><rect x="16.5" y="4" width="5.5" height="16" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
    });

    // Load existing content if any
    const existingHtml = @json($content);
    const existingCss = @json($css);

    if (existingHtml) {
        editor.setComponents(existingHtml);
    }
    if (existingCss) {
        editor.setStyle(existingCss);
    }

    // Device switching
    document.getElementById('ld-device-desktop').addEventListener('click', () => {
        editor.setDevice('Desktop');
        updateDeviceButtons('desktop');
    });
    document.getElementById('ld-device-tablet').addEventListener('click', () => {
        editor.setDevice('Tablet');
        updateDeviceButtons('tablet');
    });
    document.getElementById('ld-device-mobile').addEventListener('click', () => {
        editor.setDevice('Mobile portrait');
        updateDeviceButtons('mobile');
    });

    function updateDeviceButtons(active) {
        ['desktop', 'tablet', 'mobile'].forEach(d => {
            document.getElementById(`ld-device-${d}`).classList.toggle('bg-gray-700', d === active);
        });
    }

    // Undo/Redo
    document.getElementById('ld-undo').addEventListener('click', () => editor.UndoManager.undo());
    document.getElementById('ld-redo').addEventListener('click', () => editor.UndoManager.redo());

    // Preview - open in new tab
    document.getElementById('ld-preview').addEventListener('click', () => {
        const postId = {{ $postId ?? 'null' }};
        if (postId) {
            // Save first, then open preview
            const html = editor.getHtml();
            const css = editor.getCss();
            const components = editor.getComponents().toJSON();
            const styles = editor.getStyle().toJSON();

            @this.call('saveBuilder', html, css, components, styles).then(() => {
                // Open preview in new tab
                window.open('/preview/' + postId, '_blank');
            });
        } else {
            // Just toggle preview mode in editor
            editor.runCommand('preview');
        }
    });

    // Save
    document.getElementById('ld-save').addEventListener('click', () => {
        const html = editor.getHtml();
        const css = editor.getCss();
        const components = editor.getComponents().toJSON();
        const styles = editor.getStyle().toJSON();

        @this.call('saveBuilder', html, css, components, styles);
    });

    // Listen for save confirmation
    Livewire.on('builderSaved', () => {
        // Show success notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.textContent = 'Page saved successfully!';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    });

    // Enable rich text editing
    editor.on('component:selected', (component) => {
        if (component.get('type') === 'text' || component.is('text')) {
            component.set('editable', true);
        }
    });

    // Make all text elements editable
    editor.DomComponents.addType('text', {
        model: {
            defaults: {
                editable: true,
            },
        },
    });
});
</script>
</div>
