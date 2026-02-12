<?php

namespace MrShaneBarron\LaravelDesign\Http\Controllers;

use Illuminate\Routing\Controller;
use MrShaneBarron\LaravelDesign\Models\Category;
use MrShaneBarron\LaravelDesign\Models\Post;
use MrShaneBarron\LaravelDesign\Models\Tag;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::posts()
            ->published()
            ->with(['author', 'categories'])
            ->orderBy('published_at', 'desc')
            ->paginate(config('laraveldesign.posts_per_page', 10));

        return view('laraveldesign::blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::posts()
            ->published()
            ->where('slug', $slug)
            ->with(['author', 'categories', 'tags'])
            ->firstOrFail();

        return view('laraveldesign::blog.show', compact('post'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()
            ->published()
            ->with(['author', 'categories'])
            ->orderBy('published_at', 'desc')
            ->paginate(config('laraveldesign.posts_per_page', 10));

        return view('laraveldesign::blog.category', compact('category', 'posts'));
    }

    public function tag(string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()
            ->published()
            ->with(['author', 'categories'])
            ->orderBy('published_at', 'desc')
            ->paginate(config('laraveldesign.posts_per_page', 10));

        return view('laraveldesign::blog.tag', compact('tag', 'posts'));
    }
}
