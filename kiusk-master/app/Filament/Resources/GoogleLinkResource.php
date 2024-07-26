<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoogleLinkResource\Pages;
use App\Filament\Resources\GoogleLinkResource\RelationManagers;
use App\Models\GoogleLink;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GoogleLinkResource extends Resource
{
    protected static ?string $model = GoogleLink::class;

    protected static ?string $label = 'لینک نظرات گوگل ';

    protected static ?string $navigationLabel = 'لینک نظرات گوگل ';

    protected static ?string $pluralLabel = 'لینک نظرات گوگل ';

    protected static ?string $navigationGroup = 'امتیازات ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make([
                        'sm' => 1,
                        'xl' => 1,
                    ])->schema([
                        Forms\Components\TextInput::make('title')->label(__('Title'))->required(),

                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 1,
                    ])->schema([
                        Forms\Components\TextInput::make('url')->label(__('Url'))->required(),
                    ]),

                    // Grid::make([
                    //     'sm' => 1,
                    //     'xl' => 2,
                    // ])->schema([
                    //     Forms\Components\Toggle::make('is_confirmed')->label(__('Active'))->inline()->default(1)->required(),
                    // ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label(__('Url'))
                    ->searchable()
                    ->sortable(),
            ])
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
            'index' => Pages\ListGoogleLinks::route('/'),
            'create' => Pages\CreateGoogleLink::route('/create'),
            'edit' => Pages\EditGoogleLink::route('/{record}/edit'),
        ];
    }
}
