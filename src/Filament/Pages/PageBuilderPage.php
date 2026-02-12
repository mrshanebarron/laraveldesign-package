<?php

namespace MrShaneBarron\LaravelDesign\Filament\Pages;

use Filament\Pages\Page;
use MrShaneBarron\LaravelDesign\Models\Post;

class PageBuilderPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static string $view = 'laraveldesign::filament.pages.page-builder';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Page Builder';

    public ?int $postId = null;
    public ?Post $post = null;

    public function mount(): void
    {
        $this->postId = request()->query('post_id');

        if ($this->postId) {
            $this->post = Post::find($this->postId);
        }
    }

    public function getHeading(): string
    {
        return $this->post ? "Edit: {$this->post->title}" : 'Page Builder';
    }

    public static function getSlug(): string
    {
        return 'page-builder';
    }
}
