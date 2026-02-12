<?php

namespace MrShaneBarron\LaravelDesign\Http\Controllers;

use Illuminate\Routing\Controller;
use MrShaneBarron\LaravelDesign\Models\Post;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Post::pages()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Determine which template to use
        $template = $page->template ?: 'default';
        $viewName = "laraveldesign::pages.{$template}";

        // Fallback to default template if custom template doesn't exist
        if (!view()->exists($viewName)) {
            $viewName = 'laraveldesign::pages.default';
        }

        return view($viewName, compact('page'));
    }
}
