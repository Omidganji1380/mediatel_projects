<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\CategoryResource\Pages;
use App\Models\Blog\Category;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class CategoryResource extends Resource
{
    use \App\Filament\Resources\Lib\Seo;
    protected static ?string $label = 'دسته‌بندی ';
    protected static ?string $pluralLabel = 'دسته‌بندی ها';
    protected static ?string $model = Category::class;
    protected static ?string $slug = 'blog/categories';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'بخش وبلاگ ';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()
                ->schema([
                    TextInput::make('name')
                        ->label(__('admin.name'))
                        ->required(),
                    TextInput::make('name_en')
                        ->label(__('admin.name_en'))
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => $set(
                            'slug',
                            Str::slug($state)
                        )),
                    TextInput::make('slug')
                        ->label(__('admin.slug'))
                        ->disabled()
                        ->required()
                        ->unique(Category::class, 'slug', fn ($record) => $record),
                    MarkdownEditor::make('description')
                        ->label(__('admin.description'))
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    MarkdownEditor::make('description_en')
                        ->label(__('admin.description_en'))
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    Toggle::make('is_visible')
                        ->label(__('admin.is_visible'))
                        ->default(true),
                    SpatieTagsInput::make('tags')
                        ->label(__('admin.tags'))
                        ->type('postCategory')
                        ->suggestions(function () {
                            $vars = Tag::whereIn('type', [
                                'post',
                                'postCategory'
                            ])
                                ->get('name')
                                ->toArray();
                            return Arr::flatten($vars);
                        }),
                    SpatieMediaLibraryFileUpload::make('SpecialImage')
                        ->label(__('admin.SpecialImage'))
                        ->collection('SpecialImage')
                ])
                ->columns([
                    'sm' => 2,
                ])
                ->columnSpan(2),
            Card::make()
                ->schema([
                    Placeholder::make('created_at')
                        ->label(__('admin.created_at'))
                        ->content(fn (?Category $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('updated_at')
                        ->label(__('admin.updated_at'))
                        ->content(fn (?Category $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])
                ->columnSpan(1),
            self::seoInputs('name')
        ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->label(__('admin.name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('slug')
                ->label(__('admin.slug'))
                ->searchable()
                ->sortable(),
            BooleanColumn::make('is_visible')
                ->label(__('admin.is_visible')),
            TextColumn::make('updated_at')
                ->label(__('admin.updated_at'))
                ->date(),
        ])
            ->filters([ //
            ]);
    }

    public static function getRelations(): array
    {
        return [ //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
