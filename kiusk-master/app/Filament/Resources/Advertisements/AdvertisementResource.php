<?php

namespace App\Filament\Resources\Advertisements;

use App\Filament\Resources\Advertisements\AdvertisementResource\Pages;
use App\Filament\Resources\Advertisements\AdvertisementResource\RelationManagers;
use App\Models\Advertisement;
use App\Models\AdvertisementType;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class AdvertisementResource extends Resource
{
    protected static ?string $model = Advertisement::class;

    protected static ?string $label = 'تبلیغ';

    protected static ?string $navigationLabel = 'تبلیغات';

    protected static ?string $pluralLabel = 'تبلیغات';

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
                        Placeholder::make('advertisementOrder')
                                ->label(__('admin.advertisement_order'))
                                ->content(function (?Advertisement $record) {
                                    if ($record) {
                                        return new HtmlString(
                                            "<a href=\"" . route('filament.resources.advertisement-orders.edit', $record->adOrder) . "\" class=\"text-primary-400\">سفارش تبلیغ</a>"
                                        );
                                    }
                                    return "-";
                        }),
                        // Forms\Components\Select::make('position')->label(__('Position'))
                        //     ->options(AdvertisementType::POSITIONS)->required(),
                        Forms\Components\Select::make('status')->label(__('Status'))
                            ->options(Advertisement::STATUS)->required(),
                    ]),
                    Toggle::make('active')->label(__('admin.is_visible'))->required(),
                    // Forms\Components\Select::make('advertisement_type_id')->label(__('Advertisement Type'))
                    //         ->relationship('advertisementType', 'name_fa')->required(),
                    Forms\Components\TextInput::make('link')->label(__("Link")),
                    Textarea::make('message')->label(__('Message to user')),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (Advertisement $record) {
                        return $record->user?->full_name;
                    }),
                TextColumn::make('advertisement_type')
                    ->label(__('Advertisement Type'))
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (Advertisement $record) {
                        return $record->advertisementType?->name_fa;
                    }),
                TextColumn::make('days')
                    ->label(__('Days'))
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (Advertisement $record) {
                        return $record->adOrder?->days;
                    }),
                // ToggleColumn::make('active')
                //     ->label(__('Active'))
                //     ->sortable(),
                BooleanColumn::make('active')
                    ->label(__('Active'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListAdvertisements::route('/'),
            'create' => Pages\CreateAdvertisement::route('/create'),
            'edit' => Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }
}
