<?php

namespace MrShaneBarron\LaravelDesign\Services;

use Illuminate\Support\Facades\View;

class BlockRenderer
{
    public static function render(array $block): string
    {
        $type = $block['type'] ?? 'default';
        $content = $block['content'] ?? [];
        $settings = $block['settings'] ?? [];

        // Check if there's a custom view for this block type
        $viewName = "laraveldesign::components.blocks.{$type}";

        if (View::exists($viewName)) {
            return view($viewName, [
                'block' => $block,
                'content' => $content,
                'settings' => $settings,
            ])->render();
        }

        // Fall back to rendering the raw HTML from GrapesJS
        return self::renderComponent($content);
    }

    protected static function renderComponent(array $component): string
    {
        if (empty($component)) {
            return '';
        }

        // If it's just a string, return it
        if (isset($component['content']) && is_string($component['content'])) {
            return $component['content'];
        }

        $tagName = $component['tagName'] ?? 'div';
        $attributes = self::buildAttributes($component);
        $content = '';

        // Handle text content
        if (isset($component['content'])) {
            $content = $component['content'];
        }

        // Handle child components
        if (isset($component['components']) && is_array($component['components'])) {
            foreach ($component['components'] as $child) {
                $content .= self::renderComponent($child);
            }
        }

        // Self-closing tags
        $selfClosing = ['img', 'br', 'hr', 'input', 'meta', 'link'];
        if (in_array($tagName, $selfClosing)) {
            return "<{$tagName}{$attributes}>";
        }

        return "<{$tagName}{$attributes}>{$content}</{$tagName}>";
    }

    protected static function buildAttributes(array $component): string
    {
        $attrs = [];

        // Add classes
        if (!empty($component['classes'])) {
            $classes = is_array($component['classes'])
                ? implode(' ', array_map(fn($c) => is_array($c) ? $c['name'] ?? '' : $c, $component['classes']))
                : $component['classes'];
            $attrs[] = 'class="' . e($classes) . '"';
        }

        // Add other attributes
        if (!empty($component['attributes'])) {
            foreach ($component['attributes'] as $key => $value) {
                if ($key === 'class') continue; // Already handled
                if (is_bool($value)) {
                    if ($value) $attrs[] = $key;
                } else {
                    $attrs[] = $key . '="' . e($value) . '"';
                }
            }
        }

        // Add style
        if (!empty($component['style'])) {
            $styles = [];
            foreach ($component['style'] as $prop => $val) {
                $styles[] = "{$prop}: {$val}";
            }
            $attrs[] = 'style="' . e(implode('; ', $styles)) . '"';
        }

        return $attrs ? ' ' . implode(' ', $attrs) : '';
    }
}
