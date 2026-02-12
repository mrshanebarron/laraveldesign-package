<?php

namespace MrShaneBarron\LaravelDesign\Livewire;

use Livewire\Component;
use MrShaneBarron\LaravelDesign\Models\Post;

class PageBuilder extends Component
{
    public ?int $postId = null;
    public string $content = '';
    public string $css = '';
    public array $blocks = [];
    public array $builderData = [];

    protected $listeners = ['saveBuilder'];

    public function mount(?int $postId = null): void
    {
        $this->postId = $postId;

        if ($postId) {
            $post = Post::find($postId);
            if ($post) {
                $this->blocks = $post->blocks ?? [];
                $this->builderData = $post->builder_data ?? [];
                $this->content = $this->builderData['html'] ?? '';
                $this->css = $this->builderData['css'] ?? '';
            }
        }
    }

    public function saveBuilder(string $html, string $css, array $components, array $styles): void
    {
        $this->content = $html;
        $this->css = $css;
        $this->builderData = [
            'html' => $html,
            'css' => $css,
            'components' => $components,
            'styles' => $styles,
        ];

        // Convert GrapesJS components to our block format
        $this->blocks = $this->convertToBlocks($components);

        if ($this->postId) {
            $post = Post::find($this->postId);
            if ($post) {
                $post->update([
                    'blocks' => $this->blocks,
                    'builder_data' => $this->builderData,
                    'editor_mode' => 'builder',
                ]);
            }
        }

        $this->dispatch('builderSaved');
    }

    protected function convertToBlocks(array $components): array
    {
        $blocks = [];

        foreach ($components as $component) {
            $block = [
                'id' => $component['attributes']['id'] ?? uniqid('block_'),
                'type' => $this->detectBlockType($component),
                'content' => $component,
                'settings' => $component['attributes'] ?? [],
            ];
            $blocks[] = $block;
        }

        return $blocks;
    }

    protected function detectBlockType(array $component): string
    {
        $classes = $component['classes'] ?? [];
        $type = $component['type'] ?? 'default';

        // Detect by custom attribute
        if (isset($component['attributes']['data-block-type'])) {
            return $component['attributes']['data-block-type'];
        }

        // Detect by class
        foreach ($classes as $class) {
            if (str_starts_with($class, 'ld-block-')) {
                return str_replace('ld-block-', '', $class);
            }
        }

        return $type;
    }

    public function getBlockTypes(): array
    {
        return [
            [
                'id' => 'hero',
                'label' => 'Hero Section',
                'category' => 'Sections',
                'content' => '<section class="ld-block-hero py-20 px-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white text-center" data-block-type="hero">
                    <div class="max-w-4xl mx-auto">
                        <h1 class="text-5xl font-bold mb-6">Your Amazing Headline</h1>
                        <p class="text-xl mb-8 opacity-90">A compelling subheadline that explains your value proposition</p>
                        <a href="#" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Get Started</a>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="4" width="20" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><line x1="6" y1="10" x2="18" y2="10" stroke="currentColor" stroke-width="2"/><line x1="8" y1="14" x2="16" y2="14" stroke="currentColor" stroke-width="2"/></svg>',
            ],
            [
                'id' => 'text-block',
                'label' => 'Text Block',
                'category' => 'Basic',
                'content' => '<div class="ld-block-text py-12 px-4" data-block-type="text">
                    <div class="max-w-3xl mx-auto prose prose-lg">
                        <h2>Section Title</h2>
                        <p>Your content goes here. Click to edit this text. You can format it using the toolbar above.</p>
                    </div>
                </div>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 5h18v2H3V5zm0 6h18v2H3v-2zm0 6h12v2H3v-2z"/></svg>',
            ],
            [
                'id' => 'image-text',
                'label' => 'Image + Text',
                'category' => 'Sections',
                'content' => '<section class="ld-block-image-text py-16 px-4" data-block-type="image-text">
                    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
                        <div>
                            <img src="https://placehold.co/600x400" alt="Feature image" class="rounded-lg shadow-lg w-full">
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold mb-4">Feature Headline</h2>
                            <p class="text-gray-600 mb-6">Describe your feature or service here. Explain the benefits and why customers should care.</p>
                            <a href="#" class="text-blue-600 font-semibold hover:underline">Learn more →</a>
                        </div>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="6" width="8" height="12" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><line x1="14" y1="8" x2="22" y2="8" stroke="currentColor" stroke-width="2"/><line x1="14" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2"/><line x1="14" y1="16" x2="18" y2="16" stroke="currentColor" stroke-width="2"/></svg>',
            ],
            [
                'id' => 'features',
                'label' => 'Features Grid',
                'category' => 'Sections',
                'content' => '<section class="ld-block-features py-16 px-4 bg-gray-50" data-block-type="features">
                    <div class="max-w-6xl mx-auto">
                        <h2 class="text-3xl font-bold text-center mb-12">Our Features</h2>
                        <div class="grid md:grid-cols-3 gap-8">
                            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <h3 class="font-semibold mb-2">Feature One</h3>
                                <p class="text-gray-600 text-sm">Brief description of this amazing feature.</p>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="font-semibold mb-2">Feature Two</h3>
                                <p class="text-gray-600 text-sm">Brief description of this amazing feature.</p>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                </div>
                                <h3 class="font-semibold mb-2">Feature Three</h3>
                                <p class="text-gray-600 text-sm">Brief description of this amazing feature.</p>
                            </div>
                        </div>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="4" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><rect x="9" y="4" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><rect x="16" y="4" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><rect x="2" y="14" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><rect x="9" y="14" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="2"/><rect x="16" y="14" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
            ],
            [
                'id' => 'testimonials',
                'label' => 'Testimonials',
                'category' => 'Sections',
                'content' => '<section class="ld-block-testimonials py-16 px-4" data-block-type="testimonials">
                    <div class="max-w-6xl mx-auto">
                        <h2 class="text-3xl font-bold text-center mb-12">What Our Customers Say</h2>
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="bg-white p-8 rounded-lg shadow-sm border">
                                <p class="text-gray-600 mb-6 italic">"This product has completely transformed how we work. Highly recommended!"</p>
                                <div class="flex items-center">
                                    <img src="https://placehold.co/48x48" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                                    <div>
                                        <p class="font-semibold">Jane Smith</p>
                                        <p class="text-gray-500 text-sm">CEO, TechCorp</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-8 rounded-lg shadow-sm border">
                                <p class="text-gray-600 mb-6 italic">"Outstanding service and support. The team went above and beyond."</p>
                                <div class="flex items-center">
                                    <img src="https://placehold.co/48x48" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                                    <div>
                                        <p class="font-semibold">John Doe</p>
                                        <p class="text-gray-500 text-sm">Founder, StartupXYZ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 17h3l2-4V7H5v6h3l-2 4zm9 0h3l2-4V7h-6v6h3l-2 4z"/></svg>',
            ],
            [
                'id' => 'pricing',
                'label' => 'Pricing Table',
                'category' => 'Sections',
                'content' => '<section class="ld-block-pricing py-16 px-4 bg-gray-50" data-block-type="pricing">
                    <div class="max-w-5xl mx-auto">
                        <h2 class="text-3xl font-bold text-center mb-4">Simple Pricing</h2>
                        <p class="text-gray-600 text-center mb-12">Choose the plan that works for you</p>
                        <div class="grid md:grid-cols-3 gap-8">
                            <div class="bg-white p-8 rounded-lg shadow-sm border text-center">
                                <h3 class="font-semibold text-lg mb-2">Starter</h3>
                                <p class="text-4xl font-bold mb-4">$9<span class="text-lg text-gray-500">/mo</span></p>
                                <ul class="text-gray-600 text-sm space-y-3 mb-8">
                                    <li>5 Projects</li>
                                    <li>10GB Storage</li>
                                    <li>Email Support</li>
                                </ul>
                                <a href="#" class="block w-full py-2 border border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition">Get Started</a>
                            </div>
                            <div class="bg-blue-600 p-8 rounded-lg shadow-lg text-white text-center transform scale-105">
                                <h3 class="font-semibold text-lg mb-2">Professional</h3>
                                <p class="text-4xl font-bold mb-4">$29<span class="text-lg opacity-75">/mo</span></p>
                                <ul class="opacity-90 text-sm space-y-3 mb-8">
                                    <li>Unlimited Projects</li>
                                    <li>100GB Storage</li>
                                    <li>Priority Support</li>
                                </ul>
                                <a href="#" class="block w-full py-2 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition">Get Started</a>
                            </div>
                            <div class="bg-white p-8 rounded-lg shadow-sm border text-center">
                                <h3 class="font-semibold text-lg mb-2">Enterprise</h3>
                                <p class="text-4xl font-bold mb-4">$99<span class="text-lg text-gray-500">/mo</span></p>
                                <ul class="text-gray-600 text-sm space-y-3 mb-8">
                                    <li>Everything in Pro</li>
                                    <li>1TB Storage</li>
                                    <li>24/7 Phone Support</li>
                                </ul>
                                <a href="#" class="block w-full py-2 border border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition">Contact Sales</a>
                            </div>
                        </div>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/></svg>',
            ],
            [
                'id' => 'cta',
                'label' => 'Call to Action',
                'category' => 'Sections',
                'content' => '<section class="ld-block-cta py-16 px-4 bg-blue-600 text-white" data-block-type="cta">
                    <div class="max-w-4xl mx-auto text-center">
                        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
                        <p class="text-xl opacity-90 mb-8">Join thousands of satisfied customers today.</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Start Free Trial</a>
                            <a href="#" class="border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">Learn More</a>
                        </div>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6v-2zm0 4h8v2H6v-2zm10 0h2v2h-2v-2zm-6-4h8v2h-8v-2z"/></svg>',
            ],
            [
                'id' => 'gallery',
                'label' => 'Image Gallery',
                'category' => 'Media',
                'content' => '<section class="ld-block-gallery py-16 px-4" data-block-type="gallery">
                    <div class="max-w-6xl mx-auto">
                        <h2 class="text-3xl font-bold text-center mb-12">Gallery</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <img src="https://placehold.co/300x300" alt="Gallery image" class="rounded-lg w-full aspect-square object-cover">
                            <img src="https://placehold.co/300x300" alt="Gallery image" class="rounded-lg w-full aspect-square object-cover">
                            <img src="https://placehold.co/300x300" alt="Gallery image" class="rounded-lg w-full aspect-square object-cover">
                            <img src="https://placehold.co/300x300" alt="Gallery image" class="rounded-lg w-full aspect-square object-cover">
                        </div>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"/></svg>',
            ],
            [
                'id' => 'contact',
                'label' => 'Contact Form',
                'category' => 'Forms',
                'content' => '<section class="ld-block-contact py-16 px-4 bg-gray-50" data-block-type="contact">
                    <div class="max-w-2xl mx-auto">
                        <h2 class="text-3xl font-bold text-center mb-4">Get in Touch</h2>
                        <p class="text-gray-600 text-center mb-8">Have a question? We\'d love to hear from you.</p>
                        <form class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Your name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="you@example.com">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Your message..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Send Message</button>
                        </form>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
            ],
            [
                'id' => 'faq',
                'label' => 'FAQ',
                'category' => 'Sections',
                'content' => '<section class="ld-block-faq py-16 px-4" data-block-type="faq">
                    <div class="max-w-3xl mx-auto">
                        <h2 class="text-3xl font-bold text-center mb-12">Frequently Asked Questions</h2>
                        <div class="space-y-4">
                            <div class="border rounded-lg">
                                <button class="w-full px-6 py-4 text-left font-semibold flex justify-between items-center">
                                    <span>What is your refund policy?</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div class="px-6 pb-4 text-gray-600">
                                    We offer a 30-day money-back guarantee. If you\'re not satisfied, contact us for a full refund.
                                </div>
                            </div>
                            <div class="border rounded-lg">
                                <button class="w-full px-6 py-4 text-left font-semibold flex justify-between items-center">
                                    <span>How do I get support?</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div class="px-6 pb-4 text-gray-600">
                                    You can reach our support team via email or through the help center in your dashboard.
                                </div>
                            </div>
                            <div class="border rounded-lg">
                                <button class="w-full px-6 py-4 text-left font-semibold flex justify-between items-center">
                                    <span>Can I upgrade my plan later?</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div class="px-6 pb-4 text-gray-600">
                                    Yes! You can upgrade or downgrade your plan at any time from your account settings.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>',
                'media' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z"/></svg>',
            ],
        ];
    }

    public function render()
    {
        return view('laraveldesign::livewire.page-builder', [
            'blockTypes' => $this->getBlockTypes(),
        ]);
    }
}
