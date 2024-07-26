<?php

namespace App\Filament\Resources\Advertisements;

use App\Filament\Resources\Advertisements\AdvertisementOrderResource\Pages;
use App\Filament\Resources\Advertisements\AdvertisementOrderResource\RelationManagers;
use App\Models\Ad\Category;
use App\Models\Advertisement;
use App\Models\AdvertisementOrder;
use App\Models\AdvertisementType;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;

class AdvertisementOrderResource extends Resource
{
    protected static ?string $model = AdvertisementOrder::class;

    protected static ?string $label = 'سفارش تبلیغ کاربران';

    protected static ?string $navigationLabel = 'سفارشات تبلیغ کاربران ';

    protected static ?string $pluralLabel = 'سفارشات تبلیغ کاربران ';

    protected static ?string $navigationGroup = 'تبلیغات ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        TextInput::make('first_name')->label(__('First Name'))->required(),
                        TextInput::make('last_name')->label(__('Last Name'))->required(),

                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        TextInput::make('email')->label(__('Email'))->required()->email(),
                        TextInput::make('business_name')->label(__('Business Name')),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        TextInput::make('website')->label(__('Website')),
                        TextInput::make('url')->label(__('Url Address')),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([

                        Forms\Components\Select::make('country_code')
                            ->options(Country::pluck('dial_code', 'dial_code')->toArray())
                            ->label(__('Country Code'))
                            ->required(),
                        TextInput::make('phone')->label(__('Phone'))->required()->numeric(),
                    ])->inlineLabel(),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([

                        Forms\Components\Select::make('country_code')
                            ->options(Country::pluck('dial_code', 'dial_code')->toArray())
                            ->label(__('Country Code'))
                            ->required(),
                        TextInput::make('phone_2')->label(__('Phone 2'))->required()->numeric(),
                    ])->inlineLabel(),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        TextInput::make('price')->label(__('Price'))->required()->numeric(),
                        TextInput::make('days')->label(__('Days'))->required()->numeric(),
                    ]),
                    Select::make('category_id')
                        ->label(__('admin.category.name'))
                        ->options(function (callable $get) {
                            $ids = Arr::flatten(s()->mainPageCategories);
                            return Category::with(['ads'])
                                ->whereNotNull('extra')
                                ->whereIn('id', $ids)
                                ->orderByRaw("FIELD(id, " . implode(',', $ids) . ")")
                                ->pluck('name', 'id')
                                ->toArray();
                        }),
                    TextInput::make('title')->label(__('Persian Title')),
                    TextInput::make('title_en')->label(__('English Title')),
                    Forms\Components\RichEditor::make('description_fa')
                        ->label(__('Persian Description')),
                    Forms\Components\RichEditor::make('description_en')
                        ->label(__('English Description')),
                    SpatieMediaLibraryFileUpload::make('HomeBGLargeFa')
                        ->label(__('admin.HomeBGLargeFa'))
                        ->collection('HomeBGLargeFa'),
                    SpatieMediaLibraryFileUpload::make('HomeBGLargeEn')
                        ->label(__('admin.HomeBGLargeEn'))
                        ->collection('HomeBGLargeEn'),
                    SpatieMediaLibraryFileUpload::make('BlogBottomFa')
                        ->label(__('admin.BlogBottomFa'))
                        ->collection('BlogBottomFa'),
                    SpatieMediaLibraryFileUpload::make('BlogBottomEn')
                        ->label(__('admin.BlogBottomEn'))
                        ->collection('BlogBottomEn'),
                    SpatieMediaLibraryFileUpload::make('BlogTextFa')
                        ->label(__('admin.BlogTextFa'))
                        ->collection('BlogTextFa'),
                    SpatieMediaLibraryFileUpload::make('BlogTextEn')
                        ->label(__('admin.BlogTextEn'))
                        ->collection('BlogTextEn'),
                    SpatieMediaLibraryFileUpload::make('BlogSidebarFa')
                        ->label(__('admin.BlogSidebarFa'))
                        ->collection('BlogSidebarFa'),
                    SpatieMediaLibraryFileUpload::make('BlogSidebarEn')
                        ->label(__('admin.BlogSidebarEn'))
                        ->collection('BlogSidebarEn'),
                    // Toggle::make('exclusive_design')->label(__('Exclusive design')),
                    // Forms\Components\Select::make('position')->label(__('Position'))
                    //     ->options(AdvertisementType::POSITIONS)->required(),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user')
                    ->searchable()
                    ->sortable()
                    ->label(__('User'))
                    ->getStateUsing(function (AdvertisementOrder $record) {
                        return $record->user?->full_name;
                    }),
                TextColumn::make('advertisement_type_id')
                    ->label('Advertisement Type')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (AdvertisementOrder $record) {
                        return $record->advertisementType?->name;
                    }),
                TextColumn::make('price')
                    ->searchable()
                    ->label(__('Price'))
                    ->sortable()
                    ->getStateUsing(function (AdvertisementOrder $record) {
                        return "$" . $record->price;
                    }),
                TextColumn::make('days')
                    ->searchable()
                    ->label(__('Days'))
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->label(__('Email'))
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->label(__('Phone'))
                    ->sortable()
                    ->getStateUsing(function (AdvertisementOrder $record) {
                        return $record->country_code . $record->phone;
                    }),
                TextColumn::make('state')
                    ->searchable()
                    ->label(__('State'))
                    ->sortable()
                    ->getStateUsing(fn ($record): ?string => $record->state?->name),
                TextColumn::make('city')
                    ->searchable()
                    ->label(__('City'))
                    ->sortable()
                    ->getStateUsing(fn ($record): ?string => $record->city?->name),
                TextColumn::make('business_name')
                    ->searchable()
                    ->label(__('Business Name'))
                    ->sortable(),
                // ImageColumn::make('logo')
                //     ->label(__('Logo'))
                //     ->visibility('private'),
                // ImageColumn::make('design')
                //     ->label(__('Design'))
                //     ->visibility('private'),
                TextColumn::make('business_name')
                    ->searchable()
                    ->label(__('Business Name'))
                    ->sortable(),
                // BooleanColumn::make('exclusive_design')
                //     ->label(__('Exclusive design'))
                //     ->trueIcon('heroicon-o-badge-check')
                //     ->falseIcon('heroicon-o-x-circle')
                //     ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
                    })
            ])
            ->actions([
                Action::make('create_advertisement')
                    ->label(__('Create Advertisement'))
                    ->mountUsing(fn (Forms\ComponentContainer $form, AdvertisementOrder $record) => $form->fill([
                        'position' => $record->position,
                    ]))
                    ->url(fn (AdvertisementOrder $record): string => route('filament.resources.advertisements.create', ['advertisementOrder' => $record])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAdvertisementOrders::route('/'),
            'create' => Pages\CreateAdvertisementOrder::route('/create'),
            'edit' => Pages\EditAdvertisementOrder::route('/{record}/edit'),
        ];
    }
}
