<?php

namespace MrShaneBarron\LaravelDesign\Filament\Resources\MediaResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use MrShaneBarron\LaravelDesign\Filament\Resources\MediaResource;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle file upload
        if (isset($data['file']) && is_array($data['file'])) {
            $filePath = collect($data['file'])->first();
            if ($filePath) {
                $data['path'] = $filePath;
                $data['disk'] = 'public';

                // Get file info if not already set
                if (empty($data['name'])) {
                    $data['name'] = pathinfo($data['file_name'] ?? $filePath, PATHINFO_FILENAME);
                }
            }
            unset($data['file']);
        }

        $data['user_id'] = auth()->id();

        return $data;
    }
}
