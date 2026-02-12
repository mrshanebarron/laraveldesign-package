<?php

use Illuminate\Support\Facades\Route;
use MrShaneBarron\LaravelDesign\Http\Controllers\BlogController;
use MrShaneBarron\LaravelDesign\Http\Controllers\PageController;
use MrShaneBarron\LaravelDesign\Http\Controllers\PreviewController;

// Preview route (authenticated only)
Route::get('/preview/{id}', [PreviewController::class, 'show'])
    ->middleware(['web', 'auth'])
    ->name('laraveldesign.preview');

// Blog routes (configurable prefix)
Route::prefix(config('laraveldesign.blog_prefix', 'blog'))
    ->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('laraveldesign.blog.index');
        Route::get('/{slug}', [BlogController::class, 'show'])->name('laraveldesign.blog.show');
    });

// Category routes
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('laraveldesign.category');

// Tag routes
Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('laraveldesign.tag');

// Page routes (catch-all - should be registered last)
// Requires at least one character in slug to avoid matching root "/"
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!admin|api|login|register|logout|password|email|dashboard|livewire|filament).+$')
    ->name('laraveldesign.page.show');
