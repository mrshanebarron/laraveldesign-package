<?php

namespace MrShaneBarron\LaravelDesign\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use MrShaneBarron\LaravelDesign\Filament\Resources\MediaResource\Pages;
use MrShaneBarron\LaravelDesign\Models\Media;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Media';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Upload')
                    ->schema([
                        Forms\Components\FileUpload::make('file')
                            ->label('File')
                            ->disk('public')
                            ->directory('media')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'image/*',
                                'video/*',
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(51200) // 50MB
                            ->imagePreviewHeight('250')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $file = collect($state)->first();
                                    if ($file) {
                                        $set('file_name', $file->getClientOriginalName());
                                        $set('mime_type', $file->getMimeType());
                                        $set('size', $file->getSize());
                                    }
                                }
                            })
                            ->columnSpanFull()
                            ->hiddenOn('edit'),
                    ])
                    ->hiddenOn('edit'),

                Forms\Components\Section::make('Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('alt')
                            ->label('Alt Text')
                            ->helperText('Describe the image for accessibility')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('caption')
                            ->rows(2),

                        Forms\Components\Placeholder::make('file_info')
                            ->label('File Info')
                            ->content(fn ($record) => $record ? "{$record->file_name} ({$record->human_size})" : '')
                            ->visibleOn('edit'),

                        Forms\Components\Placeholder::make('preview')
                            ->label('Preview')
                            ->content(fn ($record) => $record && $record->is_image
                                ? new \Illuminate\Support\HtmlString("<img src=\"{$record->url}\" style=\"max-width: 300px; max-height: 200px;\" />")
                                : ($record ? $record->file_name : '')
                            )
                            ->visibleOn('edit'),

                        Forms\Components\Hidden::make('file_name'),
                        Forms\Components\Hidden::make('mime_type'),
                        Forms\Components\Hidden::make('size'),
                        Forms\Components\Hidden::make('path'),
                        Forms\Components\Hidden::make('disk')->default('public'),
                        Forms\Components\Hidden::make('user_id')->default(fn () => auth()->id()),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('url')
                    ->label('Preview')
                    ->getStateUsing(fn ($record) => $record->is_image ? $record->url : null)
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->is_image ? null : url('/vendor/laraveldesign/images/file-icon.svg')),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('file_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('mime_type')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('human_size')
                    ->label('Size'),

                Tables\Columns\TextColumn::make('uploader.name')
                    ->label('Uploaded By')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'image' => 'Images',
                        'video' => 'Videos',
                        'document' => 'Documents',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'image') {
                            return $query->where('mime_type', 'like', 'image/%');
                        }
                        if ($data['value'] === 'video') {
                            return $query->where('mime_type', 'like', 'video/%');
                        }
                        if ($data['value'] === 'document') {
                            return $query->whereIn('mime_type', [
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ]);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
