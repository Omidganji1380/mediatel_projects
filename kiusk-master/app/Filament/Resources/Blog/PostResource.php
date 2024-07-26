<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\PostResource\Pages;
use App\Filament\Resources\Blog\PostResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\Lib\Seo;
use App\Filament\Resources\Lib\UserName;
use App\Models\Blog\Post;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Tags\Tag;
use Closure;
use Illuminate\Support\HtmlString;

class PostResource extends Resource
{
    use UserName;
    use Seo;

    protected static ?string $label = 'نوشته ';
    protected static ?string $pluralLabel = 'نوشته ها';
    protected static ?string $model = Post::class;
    protected static ?string $slug = 'blog/posts';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationGroup = 'بخش وبلاگ ';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        /*dump(request()
              ->route()
              ->getName());*/
        return $form->schema([
            Card::make()
                ->schema([
                    TextInput::make('title')
                        ->label(__('admin.title'))
                        ->required(),
                    TextInput::make('title_en')
                        ->label(__('admin.title_en'))
                         ->required(),
                        // ->reactive()
                        // ->afterStateUpdated(function (Closure $set, $state) {
                        //     $set('slug', Str::slug($state));
                        // }),
                    TextInput::make('slug')
                        ->label(__('admin.slug')),
                        //->disabled()
                        // ->required()
                        // ->unique(Post::class, 'slug', fn ($record) => $record),
                    Toggle::make('is_visible')
                        ->label(__('admin.is_visible'))
                        ->inline(false),
                    // Select::make('lang')
                    //         ->label(__('Language'))
                    //         ->options(function (callable $get) {
                    //             return [
                    //                 'fa' => __('Persian'),
                    //                 'en' => __('English'),
                    //             ];
                    //         }),
                    DateTimePicker::make('created_at')
                        ->label(__('admin.created_at'))
                        ->visible(fn (Component $livewire): bool => $livewire instanceof Pages\EditPost)
                        //   ->withoutTime()
                        ->format("Y-m-d H:i:s")
                        ->displayFormat('Y-m-d H:i:s'),
                    //                                      MarkdownEditor::make('content')->$this->label(__('admin.content')
                    //                                                    ->required()
                    //                                       ->fileAttachmentsDisk('local')
                    //                                                    ->columnSpan([
                    //                                                                  'sm' => 2,
                    //                                                                 ]),
                    // ViewField::make('content')
                    //          ->label(__('admin.content'))
                    //          ->required()
                    //          ->view('forms.components.ckeditor')

                    RichEditor::make('content')->label(__('admin.content'))
                        ->toolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'undo',
                            'color',
                            'align'
                        ])
                        ->required()
                        // ->fileAttachmentsDisk('local')
                        ->fileAttachmentsDirectory('attachments')
                        ->fileAttachmentsVisibility('public')
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    RichEditor::make('content_en')->label(__('admin.content_en'))
                        // ->required()
                        // ->fileAttachmentsDisk('local')
                        ->fileAttachmentsDirectory('attachments')
                        ->fileAttachmentsVisibility('public')
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    Textarea::make('excerpt')
                        ->label(__('admin.excerpt'))
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    Textarea::make('excerpt_en')
                        ->label(__('admin.excerpt_en'))
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    SpatieMediaLibraryFileUpload::make('SpecialImage')
                        ->label(__('admin.SpecialImage'))
                        //                                                                  ->disk('ads')
                        //                                                                  ->directory('storage/app/public/aaaaaaaaaaa4455555')
                        ->collection('SpecialImage')
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    SpatieMediaLibraryFileUpload::make('SpecialImageEn')
                        ->label(__('admin.SpecialImageEn'))
                        //                                                                  ->disk('ads')
                        //                                                                  ->directory('storage/app/public/aaaaaaaaaaa4455555')
                        ->collection('SpecialImageEn')
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    SpatieMediaLibraryFileUpload::make('gallery')
                        ->label(__('admin.gallery'))
                        //                                                                  ->disk('ads')
                        //                                                                  ->directory('storage/app/public/aaaaaaaaaaa')
                        ->multiple()
                        ->collection('gallery')
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                    self::userNameSelect(),
                    BelongsToSelect::make('blog_category_id')
                        ->label(__('admin.blog_category_id'))
                        ->relationship('category', 'name')
                        ->searchable()
                        ->required(),
                    //                                      DatePicker::make('published_at')
                    //                                                ->label(__('admin.published_at')),
                    SpatieTagsInput::make('tags')
                        ->label(__('admin.tags'))
                        ->type('post')
                        ->suggestions(function () {
                            $vars = Tag::whereIn('type', [
                                'post',
                                'postCategory',
                            ])
                                ->get('name')
                                ->toArray();

                            return Arr::flatten($vars);
                        }),
                    TextInput::make('old_url')
                        ->label(__('Old Url'))->columnSpan([
                            'sm' => 2,
                        ]),
                    TextInput::make('current_url')
                        ->label(__('Current Url'))->columnSpan([
                            'sm' => 2,
                        ]),
                    TextInput::make('rel_canonical')
                        ->label(__('Conanical'))->columnSpan([
                            'sm' => 2,
                        ]),
                ])
                ->columns([
                    'sm' => 2,
                ])
                ->columnSpan(2),
            Card::make()
                ->schema([
                    Placeholder::make('created_at')
                        ->label(__('admin.created_at'))
                        ->content(fn (?Post $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('log.createdBy.name')
                        ->label(__('Created By'))
                        ->content(function (?Post $record) {
                            if ($record) {
                                if ($record->log?->createdBy?->name_with_role) {
                                    return new HtmlString(
                                        "<a href=\"" . route('filament.resources.users.edit', $record->log?->createdBy) . "\" class=\"text-primary-400\">{$record->log?->createdBy?->name_with_role}</a>"
                                    );
                                } elseif ($record->user) {
                                    return new HtmlString(
                                        "<a href=\"" . route('filament.resources.users.edit', $record->user) . "\" class=\"text-primary-400\">{$record->user?->name_with_role}</a>"
                                    );
                                }
                            }
                            return "-";
                        }),
                    Placeholder::make('updated_at')
                        ->label(__('admin.updated_at'))
                        ->content(fn (?Post $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    Placeholder::make('log.updatedBy.name')
                        ->label(__('Updated By'))
                        ->content(function (?Post $record) {
                            if ($record) {
                                if ($record->log?->updatedBy?->name_with_role) {
                                    return new HtmlString(
                                        "<a href=\"" . route('filament.resources.users.edit', $record->log?->updatedBy) . "\" class=\"text-primary-400\">{$record->log?->updatedBy?->name_with_role}</a>"
                                    );
                                } elseif ($record->user) {
                                    return new HtmlString(
                                        "<a href=\"" . route('filament.resources.users.edit', $record->user) . "\" class=\"text-primary-400\">{$record->user?->name_with_role}</a>"
                                    );
                                }
                            }
                            return "-";
                        })
                ])
                ->columnSpan(1),
            self::seoInputsPost(),
        ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')
                ->label(__('admin.title'))
                ->searchable()
                ->sortable(),
            TextColumn::make('title_en')
                ->label(__('admin.title_en'))
                ->searchable()
                ->sortable(),
            //                          TextColumn::make('slug')->$this->label(__('admin.slug')
            //                                    ->searchable()
            //                                    ->sortable(),
            self::userNameColumn(),
            TextColumn::make('category.name')
                ->label(__('admin.category.name'))
                ->searchable()
                ->sortable(),
            BooleanColumn::make('no_index')
                ->label(__('No Index'))
                ->trueIcon('heroicon-o-badge-check')
                ->falseIcon('heroicon-o-x-circle')
                ->sortable(),
            TextColumn::make('created_at')
                ->label(__('admin.created_at'))
                ->date(),
        ])
        ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('published_at')
                    ->label(__('admin.published_at'))
                    ->form([
                        DatePicker::make('created_from')
                            ->label(__('admin.created_from'))
                            ->placeholder(fn ($state): string => now()
                                ->subYear()
                                ->format('M d, Y')),
                        DatePicker::make('created_until')
                            ->label(__('admin.created_until'))
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate(
                                'created_at',
                                '>=',
                                $date
                            ),
                        )
                            ->when($data['created_until'], fn (
                                Builder $query,
                                $date
                            ): Builder => $query->whereDate(
                                'created_at',
                                '<=',
                                $date
                            ),);
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with([
                'user',
                'category',
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'title',
            'slug',
            'user.name',
            'category.name',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];
        if ($record->user) {
            $details['User'] = $record->user->name;
        }
        if ($record->category) {
            $details['Category'] = $record->category->name;
        }

        return $details;
    }
}
