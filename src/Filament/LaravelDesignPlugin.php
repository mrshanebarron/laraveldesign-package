<?php

namespace MrShaneBarron\LaravelDesign\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use MrShaneBarron\LaravelDesign\Filament\Resources\CategoryResource;
use MrShaneBarron\LaravelDesign\Filament\Resources\MediaResource;
use MrShaneBarron\LaravelDesign\Filament\Resources\MenuResource;
use MrShaneBarron\LaravelDesign\Filament\Resources\PageResource;
use MrShaneBarron\LaravelDesign\Filament\Resources\PostResource;
use MrShaneBarron\LaravelDesign\Filament\Resources\TagResource;
use MrShaneBarron\LaravelDesign\Filament\Pages\PageBuilderPage;

class LaravelDesignPlugin implements Plugin
{
    public function getId(): string
    {
        return 'laraveldesign';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                PostResource::class,
                PageResource::class,
                CategoryResource::class,
                TagResource::class,
                MenuResource::class,
                MediaResource::class,
            ])
            ->pages([
                PageBuilderPage::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }
}
