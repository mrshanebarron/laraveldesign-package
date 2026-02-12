<?php

namespace MrShaneBarron\LaravelDesign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MrShaneBarron\LaravelDesign\Models\Post;

class PreviewController extends Controller
{
    public function show(Request $request, int $id)
    {
        $page = Post::findOrFail($id);

        // Return preview view with page data
        return view('laraveldesign::preview', [
            'page' => $page,
        ]);
    }
}
