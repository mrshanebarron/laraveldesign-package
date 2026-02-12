<?php

namespace MrShaneBarron\LaravelDesign\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use MrShaneBarron\LaravelDesign\Filament\Resources\PostResource;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'post';
        $data['user_id'] = auth()->id();

        return $data;
    }
}
