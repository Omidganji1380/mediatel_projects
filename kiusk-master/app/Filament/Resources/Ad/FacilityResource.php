<?php

namespace App\Filament\Resources\Ad;

use App\Filament\Resources\Ad\FacilityResource\Pages;
use App\Filament\Resources\Ad\FacilityResource\RelationManagers;
use App\Models\Ad\Facility;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $label = 'امکانات ';
    protected static ?string $pluralLabel = 'امکانات';
    protected static ?string $navigationGroup = 'بخش آگهی ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('fa_name')
                        ->label(__('admin.persian_name'))
                        ->required(),
                    TextInput::make('en_name')
                        ->label(__('admin.english_name'))
                        ->required(),
                    Select::make('type')->options(Facility::FACILITY_TYPES)
                        ->label(__('admin.facility_types'))
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fa_name')->label(__('admin.persian_name'))->searchable()->sortable(),
                TextColumn::make('en_name')->label(__('admin.english_name'))->searchable()->sortable(),
                TextColumn::make('type')->label(__('admin.facility_types'))->searchable()->sortable(),
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
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
        ];
    }
}
