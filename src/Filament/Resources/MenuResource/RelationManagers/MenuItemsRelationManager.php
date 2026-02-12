<?php

namespace MrShaneBarron\LaravelDesign\Filament\Resources\MenuResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use MrShaneBarron\LaravelDesign\Models\MenuItem;
use MrShaneBarron\LaravelDesign\Models\Post;

class MenuItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'allItems';

    protected static ?string $title = 'Menu Items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('type')
                    ->options([
                        'custom' => 'Custom URL',
                        'page' => 'Page',
                        'post' => 'Post',
                    ])
                    ->default('custom')
                    ->required()
                    ->live(),

                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'custom')
                    ->required(fn (Forms\Get $get): bool => $get('type') === 'custom'),

                Forms\Components\Select::make('linkable_id')
                    ->label('Page')
                    ->options(fn () => Post::where('type', 'page')->published()->pluck('title', 'id'))
                    ->searchable()
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'page')
                    ->required(fn (Forms\Get $get): bool => $get('type') === 'page')
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('linkable_type', Post::class)),

                Forms\Components\Select::make('linkable_id')
                    ->label('Post')
                    ->options(fn () => Post::where('type', 'post')->published()->pluck('title', 'id'))
                    ->searchable()
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'post')
                    ->required(fn (Forms\Get $get): bool => $get('type') === 'post')
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('linkable_type', Post::class)),

                Forms\Components\Select::make('parent_id')
                    ->label('Parent Item')
                    ->options(fn ($record, $livewire) => MenuItem::query()
                        ->where('menu_id', $livewire->ownerRecord->id)
                        ->when($record, fn ($query) => $query->where('id', '!=', $record->id))
                        ->pluck('label', 'id')
                    )
                    ->searchable()
                    ->placeholder('None (Top Level)'),

                Forms\Components\Select::make('target')
                    ->options([
                        '_self' => 'Same Window',
                        '_blank' => 'New Window',
                    ])
                    ->default('_self'),

                Forms\Components\TextInput::make('css_class')
                    ->label('CSS Class'),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),

                Forms\Components\Hidden::make('linkable_type')
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->reorderable('order')
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'custom',
                        'success' => 'page',
                        'info' => 'post',
                    ]),

                Tables\Columns\TextColumn::make('parent.label')
                    ->label('Parent'),

                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (in_array($data['type'], ['page', 'post'])) {
                            $data['linkable_type'] = Post::class;
                        }
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (in_array($data['type'], ['page', 'post'])) {
                            $data['linkable_type'] = Post::class;
                        }
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
    }
}
