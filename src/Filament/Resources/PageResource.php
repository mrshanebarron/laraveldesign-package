<?php

namespace MrShaneBarron\LaravelDesign\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use MrShaneBarron\LaravelDesign\Filament\Resources\PageResource\Pages;
use MrShaneBarron\LaravelDesign\Models\Post;

class PageResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $modelLabel = 'Page';

    protected static ?string $pluralModelLabel = 'Pages';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'page');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) =>
                                        $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                                    )
                                    ->suffixAction(
                                        class_exists(\MrShaneBarron\LaravelDesignPneuma\Filament\Actions\PneumaActions::class)
                                            ? \MrShaneBarron\LaravelDesignPneuma\Filament\Actions\PneumaActions::draftFromTitle('content')
                                            : null
                                    ),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(Post::class, 'slug', ignoreRecord: true),

                                Forms\Components\ToggleButtons::make('editor_mode')
                                    ->label('Editor Mode')
                                    ->options([
                                        'classic' => 'Classic Editor',
                                        'builder' => 'Visual Builder',
                                    ])
                                    ->default('classic')
                                    ->inline()
                                    ->columnSpanFull()
                                    ->live(),

                                Forms\Components\RichEditor::make('content')
                                    ->columnSpanFull()
                                    ->visible(fn (Forms\Get $get) => $get('editor_mode') !== 'builder')
                                    ->hintActions(
                                        class_exists(\MrShaneBarron\LaravelDesignPneuma\Filament\Actions\PneumaActions::class)
                                            ? [
                                                \MrShaneBarron\LaravelDesignPneuma\Filament\Actions\PneumaActions::summarize('content', 'excerpt'),
                                                \MrShaneBarron\LaravelDesignPneuma\Filament\Actions\PneumaActions::translate('content', 'content'),
                                            ]
                                            : []
                                    ),

                                Forms\Components\Placeholder::make('builder_notice')
                                    ->label('')
                                    ->content('This page uses the Visual Builder. Click "Visual Editor" in the table to edit.')
                                    ->visible(fn (Forms\Get $get) => $get('editor_mode') === 'builder')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->label('Meta Title'),

                                Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(3)
                                    ->hintActions(
                                        class_exists(\MrShaneBarron\LaravelDesignPneuma\Filament\Actions\PneumaActions::class)
                                            ? [\MrShaneBarron\LaravelDesignPneuma\Filament\Actions\PneumaActions::metaDescription('content', 'meta_description')]
                                            : []
                                    ),
                            ])
                            ->collapsed(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                    ])
                                    ->default('draft')
                                    ->required(),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publish Date'),

                                Forms\Components\Hidden::make('type')
                                    ->default('page'),

                                Forms\Components\Hidden::make('user_id')
                                    ->default(fn () => auth()->id()),
                            ]),

                        Forms\Components\Section::make('Page Settings')
                            ->schema([
                                Forms\Components\Select::make('parent_id')
                                    ->label('Parent Page')
                                    ->options(fn ($record) => Post::query()
                                        ->where('type', 'page')
                                        ->when($record, fn ($query) => $query->where('id', '!=', $record->id))
                                        ->pluck('title', 'id')
                                    )
                                    ->searchable()
                                    ->placeholder('None (Top Level)'),

                                Forms\Components\TextInput::make('order')
                                    ->numeric()
                                    ->default(0),

                                Forms\Components\Select::make('template')
                                    ->options(config('laraveldesign.page_templates', ['default' => 'Default']))
                                    ->default('default')
                                    ->placeholder('Select template'),
                            ]),

                        Forms\Components\Section::make('Featured Image')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->directory('pages')
                                    ->visibility('public'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),

                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Parent'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                    ]),

                Tables\Columns\TextColumn::make('template')
                    ->default('default'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Action::make('visual_editor')
                    ->label('Visual Editor')
                    ->icon('heroicon-o-squares-plus')
                    ->color('success')
                    ->url(fn (Post $record): string => route('filament.admin.pages.page-builder', ['post_id' => $record->id])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
