<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\Tickets\TicketCategoryResource\Pages;
use App\Filament\Resources\Tickets\TicketCategoryResource\RelationManagers;
use App\Models\TicketCategory;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class TicketCategoryResource extends Resource
{
    protected static ?string $model = TicketCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'دسته بندی تیکت ';

    protected static ?string $navigationLabel = 'دسته بندی تیکت ها ';

    protected static ?string $pluralLabel = 'دسته بندی تیکت ها ';

    protected static ?string $navigationGroup = 'تیکت ها ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('title')->label(__('Persian Title'))->required(),
                    TextInput::make('title_en')->label(__('English Title'))->required(),
                    // Select::make('parent_id')->label(__('Parent'))
                    //         ->options(TicketCategory::pluck('title', 'id')),
                    BelongsToSelect::make('parent_id')
                        ->relationship('parent', 'title'),
                    Textarea::make('description')->label(__('Persian Description')),
                    Textarea::make('description_en')->label(__('English Description')),
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
                TextColumn::make('title_en')
                    ->label(__('English Title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent')
                    ->label(__('Parent'))
                    ->getStateUsing(function (TicketCategory $record) {
                        return $record->parent->title ?? null;
                    })
                    ->searchable()
                    ->sortable(),
                BooleanColumn::make('is_visible')
                    ->action(function($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->label(__('Active'))
            ])
            ->filters([
                //
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
            'index' => Pages\ListTicketCategories::route('/'),
            'create' => Pages\CreateTicketCategory::route('/create'),
            'edit' => Pages\EditTicketCategory::route('/{record}/edit'),
        ];
    }
}
