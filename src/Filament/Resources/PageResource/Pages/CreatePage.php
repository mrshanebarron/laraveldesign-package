<?php

namespace MrShaneBarron\LaravelDesign\Filament\Resources\PageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use MrShaneBarron\LaravelDesign\Filament\Resources\PageResource;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'page';
        $data['user_id'] = auth()->id();

        return $data;
    }
}
