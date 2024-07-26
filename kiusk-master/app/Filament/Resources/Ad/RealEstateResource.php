<?php

namespace App\Filament\Resources\Ad;

use App\Filament\Resources\Ad\RealEstateResource\Pages;
use App\Filament\Resources\Ad\RealEstateResource\RelationManagers;
use App\Filament\Resources\Lib\UserName;
use App\Models\Ad\Ad;
use App\Models\Ad\RealEstateDetail;
use App\Models\Ad\Category;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\Log;
use App\Models\User;
use App\Rules\Seo;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
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
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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
use Filament\Forms\Components\View;
use Filament\Forms\Components\ViewField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RealEstateResource extends Resource
{
    use UserName;
    use \App\Filament\Resources\Lib\Seo;

    protected static ?string $model = Ad::class;
    protected static ?string $slug = 'realestate';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $label = 'آگهی املاک ';
    protected static ?string $pluralLabel = 'آگهی املاک';
    protected static ?string $navigationGroup = 'بخش آگهی ';

    public static function form(Form $form): Form
    {
        $columns = Card::make()
            ->schema([
                TextInput::make('title')
                    ->label(__('admin.title'))
                    ->required(),
                TextInput::make('title_en')
                    ->label(__('English Title'))
                    ->required(),
                TextInput::make('slug')
                    ->label(__('admin.slug'))
                    ->unique(ignorable: fn (?Model $record): ?Model => $record),
                TextInput::make('price')
                    ->label(__('admin.price'))
                    ->numeric(),
                Toggle::make('is_visible')
                    ->label(__('admin.is_visible'))
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
                Toggle::make('is_property_applicant')
                    ->label('آگهی متقاضی ملک')
                    ->inline(false),
                DateTimePicker::make('created_at')
                    ->label(__('admin.created_at'))
                    ->visible(fn (Component $livewire): bool => $livewire instanceof Pages\EditAd)
                    ->withoutTime()
                    ->format("Y-m-d H:i:s")
                    ->displayFormat('Y-m-d'),
                self::userNameSelect(),
            ])
            ->columns([
                'md' => 2,
                'sm' => 1,
            ])
            ->columnSpan(3);
        $columnSpan = Card::make()
            ->schema([
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
                    ->content(function(?Ad $record){
                        if($record){
                            if($record->log?->createdBy?->name_with_role){
                                return new HtmlString(
                                    "<a href=\"".route('filament.resources.users.edit', $record->log?->createdBy)."\" class=\"text-primary-400\">{$record->log?->createdBy?->name_with_role}</a>"
                                );
                            }elseif($record->user){
                                return new HtmlString(
                                    "<a href=\"".route('filament.resources.users.edit', $record->user)."\" class=\"text-primary-400\">{$record->user?->name_with_role}</a>"
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
                    ->content(function(?Ad $record){
                        if($record){
                            if($record->log?->updatedBy?->name_with_role){
                                return new HtmlString(
                                    "<a href=\"".route('filament.resources.users.edit', $record->log?->updatedBy)."\" class=\"text-primary-400\">{$record->log?->updatedBy?->name_with_role}</a>"
                                );
                            }elseif($record->user){
                                return new HtmlString(
                                    "<a href=\"".route('filament.resources.users.edit', $record->user)."\" class=\"text-primary-400\">{$record->user?->name_with_role}</a>"
                                );
                            }
                        }
                        return "-";
                    })
            ])
            ->columns(1)
            ->columnSpan(1);

        $columnSpan5 = Card::make()
                    ->schema([
                        Select::make('sale_type')
                            ->options(Category::SALE_TYPES)
                            ->label(__('admin.sale_type'))
                            ->reactive(),
                        TextInput::make('realEstateDetail.rent_price')
                            ->label(__('admin.rent_price'))
                            ->numeric()
                            ->hidden(fn (Closure $get) => $get('sale_type') !== 'rent'),
                        TextInput::make('realEstateDetail.mortgage_price')
                            ->label(__('admin.mortgage_price'))
                            ->numeric()
                            ->hidden(fn (Closure $get) => $get('sale_type') !== 'rent'),
                        TextInput::make('realEstateDetail.sale_price')
                            ->label(__('admin.sale_price'))
                            ->numeric()
                            ->hidden(fn (Closure $get) => $get('sale_type') !== 'sale'),
                        TextInput::make('realEstateDetail.price_keep')
                            ->label(__('admin.price_keep'))
                            ->numeric()
                            ->hidden(fn (Closure $get) => $get('sale_type') !== 'sale'),
                        TextInput::make('realEstateDetail.yearly_tax')
                            ->label(__('admin.yearly_tax'))
                            ->numeric()
                            ->hidden(fn (Closure $get) => $get('sale_type') !== 'sale'),
                        TextInput::make('realEstateDetail.bathroom')
                            ->label(__('admin.bathroom'))
                            ->numeric(),
                        TextInput::make('realEstateDetail.rooms')
                            ->label(__('admin.rooms'))
                            ->numeric(),
                        TextInput::make('realEstateDetail.floor')
                            ->label(__('admin.floor'))
                            ->numeric(),
                        TextInput::make('realEstateDetail.area')
                            ->label(__('admin.area'))
                            ->numeric(),
                        Select::make('realEstateDetail.area_unit')
                            ->options(RealEstateDetail::AREA_UNIT)
                            ->label(__('admin.area_unit')),
                        Select::make('realEstateDetail.construction_year')
                            ->options(range(now()->year, 1940))
                            ->label(__('admin.construction_year')),
                        DatePicker::make('realEstateDetail.availability_date')
                            ->label(__('admin.availability_date')),
                        RichEditor::make('message')->label(__('Message to user')),
                    ])->columns([
                        'md' => 2,
                        'sm' => 1,
                    ]);

        return $form->schema([
            $columns,
            $columnSpan,
            $columnSpan1,
            $columnSpan2,
            $columnSpan5,
            $columnSpan3,
            $columnSpan4,
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
            BooleanColumn::make('is_property_applicant')
                ->label(__('admin.is_property_applicant'))
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
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
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
                Filter::make('is_property_applicant')
                    ->label(__('admin.is_property_applicant'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_property_applicant', true)),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRealEstates::route('/'),
            'create' => Pages\CreateRealEstate::route('/create'),
            'edit' => Pages\EditRealEstate::route('/{record}/edit'),
        ];
    }
}
