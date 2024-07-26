<?php

namespace App\Filament\Resources\Advertisements;

use App\Filament\Resources\Advertisements\AdvertisementTypeResource\Pages;
use App\Filament\Resources\Advertisements\AdvertisementTypeResource\RelationManagers;
use App\Models\AdvertisementType;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdvertisementTypeResource extends Resource
{
    protected static ?string $model = AdvertisementType::class;

    protected static ?string $label = 'نوع تبلیغ';

    protected static ?string $navigationLabel = 'نوع تبلیغات ';

    protected static ?string $pluralLabel = 'نوع تبلیغات ';

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
                        TextInput::make('name_fa')->label(__('admin.persian_title'))->required(),
                        TextInput::make('name_en')->label(__('admin.english_title'))
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    ]),
                    TextInput::make('slug')->label(__('admin.slug'))
                            ->required(),
                    TextInput::make('price')->label(__('admin.price'))->required()->numeric(),
                    SpatieMediaLibraryFileUpload::make('image')
                        ->label(__('Image'))
                        ->collection('image'),
                    SpatieMediaLibraryFileUpload::make('image_en')
                        ->label(__('English Image'))
                        ->collection('image_en'),
                    Forms\Components\Select::make('position')->label(__('Position'))
                        ->options(AdvertisementType::POSITIONS)->required(),
                    Forms\Components\Toggle::make('is_visible')->label(__('Active'))->inline()->default(0)->required(),
                    Forms\Components\RichEditor::make('description_fa')
                        ->label(__('Persian Description')),
                    Forms\Components\RichEditor::make('description_en')
                        ->label(__('English Description')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_fa')
                    ->label(__('admin.persian_title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_en')
                    ->label(__('admin.english_title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('position')
                    ->label(__('Position'))
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (AdvertisementType $record) {
                        return AdvertisementType::POSITIONS[$record->position] ?? "";
                    }),
                TextColumn::make('price')
                    ->label(__('admin.price'))
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (AdvertisementType $record) {
                        return "$" . $record->price;
                    }),
                TextColumn::make('description_fa')
                    ->label(__('Persian Description'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description_en')
                    ->label(__('English Description'))
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
            'index' => Pages\ListAdvertisementTypes::route('/'),
            'create' => Pages\CreateAdvertisementType::route('/create'),
            'edit' => Pages\EditAdvertisementType::route('/{record}/edit'),
        ];
    }
}
