<?php

namespace App\Filament\Resources\Ad;

use App\Filament\Resources\Ad\AdResource\Pages;
use App\Filament\Resources\Ad\AdResource\RelationManagers;
use App\Filament\Resources\Lib\UserName;
use App\Forms\Components\ckeditor;
use App\Forms\Components\RangeSlider;
use App\Models\Ad\Ad;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\Log;
use App\Models\User;
use App\Rules\Seo;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\View;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;
use RVxLab\FilamentColorPicker\Forms\ColorPicker;
use Spatie\Tags\Tag;
use Filament\Tables\Columns\ToggleColumn;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class AdResource extends Resource
{
    use UserName;
    use \App\Filament\Resources\Lib\Seo;

    protected static ?string $label = 'آگهی ';
    protected static ?string $pluralLabel = ' آگهی ها';
    protected static ?string $model = Ad::class;
    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'بخش آگهی ';
    public $file = 'sssssssss';

    // public $title;
    public static function form(Form $form): Form
    {
        $columns = Card::make()
            ->schema([
                TextInput::make('title')
                    ->label(__('admin.title'))
                    ->required(),
                TextInput::make('title_en')
                    ->label(__('English Title'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                // ->afterStateHydrated(function ($state) {
                // $this->title = $state;
                // request()->request->add([
                //                         'title' => $state
                //                         ]);
                // })
                // ->afterStateUpdated(function ($state, callable $set) {
                //     $set('slug', Str::slug($state));
                // $this->title = $state;
                // request()->request->add([
                //                         'title' => $state,
                //                         ]);
                // }),
                TextInput::make('slug')
                    ->label(__('admin.slug'))
                    ->required()
                    ->unique(ignorable: fn (?Model $record): ?Model => $record),
                // ->reactive()
                // ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('price')
                    ->label(__('admin.price'))
                    ->numeric(),
                Toggle::make('is_visible')
                    ->label(__('admin.is_visible') . " (" . __('Confirm') . ")")
                    ->helperText('چنانچه آگهی مورد تایید نباشد آگهی قابل مشاهده نیست و از قسمت پیام به کاربر دلیل مورد تایید نبودن آن را نوشته و دکمه ذخیره کردن را بزنید.')
                    ->inline(false),
                TextInput::make('phone')
                    ->label('شماره تماس')
                    ->helperText('چنانچه شماره تماس خالی باشد، شماره تماس کاربر نمایش داده خواهد شد.'),
                Toggle::make('is_visible_phone')
                    ->label('شماره تلفن در آگهی نمایش داده شود')
                    ->inline(false),
                TextInput::make('email')
                    ->label('ایمیل')
                    ->helperText('چنانچه فیلد ایمیل خالی باشد، ایمیل کاربر نمایش داده خواهد شد.'),
                Toggle::make('is_visible_email')
                    ->label('ایمیل در آگهی نمایش داده شود')
                    ->inline(false),
                Toggle::make('is_featured')
                    ->label('آگهی ویژه')
                    ->inline(false),
                Toggle::make('is_sidebar_featured')
                    ->label('آگهی ویژه سایدبار')
                    ->inline(false),
                Toggle::make('is_suggestion_featured')
                    ->label('آگهی ویژه پیشنهادی')
                    ->inline(false),
                // DateTimePicker::make('created_at')
                //     ->label(__('admin.created_at'))
                //     ->visible(fn (Component $livewire): bool => $livewire instanceof Pages\EditAd)
                //     // ->withoutTime()
                //     ->format("Y-m-d H:i:s")
                //     ->displayFormat('Y-m-d H:i:s'),
                // self::userNameSelect(),
            ])
            ->columns([
                'md' => 2,
                'sm' => 1,
            ])
            ->columnSpan(3);
        $columnSpan = Card::make()
            ->schema([
                // ViewField::make('content')
                //          ->label(__('admin.content'))
                //          ->view('forms.components.ckeditor'),
                RichEditor::make('content')
                    ->label(__('admin.content'))
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                RichEditor::make('content_en')
                    ->label(__('English Content'))
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                //View::make('forms.components.seo')
                // ->statePath('file')
                //         ->label(__('admin.content'))
                //         ->view('forms.components.ckeditor')
                //,
                //RichEditor::make('content')->$this->label(__('admin.content')
                //          ->disableToolbarButtons([
                //                                   'attachFiles',
                //                                   'codeBlock',
                //                                  ]),,'des'
                Textarea::make('excerpt')
                    ->label(__('admin.excerpt'))
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Textarea::make('excerpt_en')
                    ->label(__('English Excerpt'))
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                TextInput::make('rel_canonical')
                    ->label(__('Canonical'))->columnSpan([
                        'sm' => 2,
                    ]),
                Toggle::make('no_index')
                    ->label('آگهی ایندکس نشود')
                    ->inline(false),
            ])
            ->columnSpan(3);
        $columnSpan1 = Card::make()
            ->schema([
                Select::make('state_id')
                    ->label(__('admin.state_id'))
                    ->options(function (callable $get) {
                        return State::all()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                Select::make('city_id')
                    ->label(__('admin.city_id'))
                    ->options(function (callable $get) {
                        $state = State::find($get('state_id'));
                        if (!$state) {
                            return City::all()
                                ->pluck('name', 'id');
                        }

                        return $state->cities->pluck('name', 'id');
                    }),
            ])
            ->columns([
                'sm' => 1,
            ])
            ->columnSpan(1);
        $columnSpan2 = Card::make()
            ->schema([
                SpatieTagsInput::make('tags')
                    ->label(__('admin.tags'))
                    ->type('ad')
                    ->suggestions(function () {
                        $vars = Tag::whereIn('type', [
                            'ad',
                            'adCategory',
                        ])
                            ->get('name')
                            ->toArray();

                        return Arr::flatten($vars);
                    }),
            ])
            ->columns([
                'sm' => 1,
            ])
            ->columnSpan(1);
        $columnSpan3 = Card::make()
            ->schema([
                SpatieMediaLibraryFileUpload::make('SpecialImage')
                    ->label(__('admin.SpecialImage'))
                    //  ->responsiveImages()
                    // ->imageCropAspectRatio('16:9')
                    ->collection('SpecialImage'),
                SpatieMediaLibraryFileUpload::make('SpecialImageEn')
                    ->label(__('admin.SpecialImageEn'))
                    //  ->responsiveImages()
                    // ->imageCropAspectRatio('16:9')
                    ->collection('SpecialImageEn'),
                SpatieMediaLibraryFileUpload::make('SpecialVideo')
                    ->label(__('admin.SpecialVideo'))
                    ->collection('SpecialVideo')
                    ->acceptedFileTypes(['video/*']),
                SpatieMediaLibraryFileUpload::make('Gallery')
                    ->label(__('admin.Gallery'))
                    ->collection('Gallery')
                    ->multiple()
                    ->maxFiles(10),
            ])
            ->columns([
                'sm' => 2,
            ])
            ->columnSpan(2);
        $columnSpan4 = Card::make()
            ->schema([
                Placeholder::make('created_at')
                    ->label(__('admin.created_at'))
                    ->content(fn (?Ad $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                Placeholder::make('log.createdBy.name')
                    ->label(__('Created By'))
                    ->content(function (?Ad $record) {
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
                // ->content(fn (?Ad $record): string => $record ? ($record->log?->createdBy?->name_with_role ?? $record->user?->name_with_role) : '-'),
                // ->content(fn (?Ad $record) => $record->log->createdBy->email ),
                Placeholder::make('updated_at')
                    ->label(__('admin.updated_at'))
                    ->content(fn (?Ad $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                Placeholder::make('log.updatedBy.name')
                    ->label(__('Updated By'))
                    // ->content(fn (?Ad $record): string => $record ? ($record->log?->updatedBy?->name_with_role ?? $record->user?->name_with_role) : '-'),
                    ->content(function (?Ad $record) {
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
            ->columns(1)
            ->columnSpan(1);

        $columnSpan5 = Card::make()->schema([
            Textarea::make('message')->label(__('Message to user')),
        ])->columnSpan('full');

        return $form->schema([
            $columns,
            $columnSpan,
            $columnSpan1,
            $columnSpan2,
            $columnSpan3,
            $columnSpan4,
            $columnSpan5,
            self::seoInputsAd(),
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
            TextColumn::make('mainCategory.name')
                ->label(__('admin.category.name'))
                ->searchable()
                ->sortable(),
            BooleanColumn::make('is_visible')
                ->label(__('admin.is_visible'))
                ->trueIcon('heroicon-o-badge-check')
                ->falseIcon('heroicon-o-x-circle')
                ->sortable(),
            BooleanColumn::make('is_featured')
                ->label(__('admin.is_featured'))
                ->trueIcon('heroicon-o-badge-check')
                ->falseIcon('heroicon-o-x-circle')
                ->sortable(),

            TextColumn::make('state')
                ->label(__('admin.state'))
                ->getStateUsing(fn ($record): ?string => $record->state?->name),
            TextColumn::make('city')
                ->label(__('admin.city'))
                ->getStateUsing(fn ($record): ?string => $record->city?->name),
            self::userNameColumn(),
            TextColumn::make('updated_at')
                ->label(__('admin.updated_at'))
                ->dateTime()
                ->searchable()
                ->sortable(),
        ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->displayFormat('Y-m-d'),
                        Forms\Components\DatePicker::make('created_until')->displayFormat('Y-m-d'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Filter::make('is_featured')
                    ->label(__('Special Ad'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),
                SelectFilter::make('user_id')->label(__('Users'))
                    ->multiple()
                    ->options(User::select(DB::raw("IFNULL(NULLIF(name, ''), email) AS display_value"), 'id')
                        ->pluck('display_value', 'id'))
            ])
            ->bulkActions([
                ExportBulkAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CategoriesRelationManager::class,
            RelationManagers\ReportsRelationManager::class,
            RelationManagers\FavoritesRelationManager::class,
            RelationManagers\ReviewsRelationManager::class,
            //   RelationManagers\AttributesRelationManager::class,
            RelationManagers\Attributes2RelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }

    public function asssssss(
        string|Closure|null $table = null,
        string|Closure|null $column = null,
        Model|Closure       $ignorable = null,
        ?Closure $callback = null
    ): static {
        $this->rule(function (Field $component) use ($callback, $column, $ignorable, $table) {
            $table = $component->evaluate($table) ?? $component->getModelClass();
            $column = $component->evaluate($column) ?? $component->getName();
            $ignorable = $component->evaluate($ignorable);
            $rule = Rule::unique($table, $column)
                ->when($ignorable, fn (Unique $rule) => $rule->ignore(
                    $ignorable->getOriginal($ignorable->getKeyName()),
                    $ignorable->getKeyName(),
                ),);
            if ($callback) {
                $rule = $this->evaluate($callback, [
                    'rule' => $rule,
                ]);
            }

            return $rule;
        }, fn (Field $component): bool => (bool)($component->evaluate($table) ?? $component->getModelClass()));

        return $this;
    }
}
