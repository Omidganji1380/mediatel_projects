<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\Tickets\TicketResource\Pages;
use App\Filament\Resources\Tickets\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'تیکت ';

    protected static ?string $navigationLabel = 'تیکت ها ';

    protected static ?string $pluralLabel = 'تیکت ها ';

    protected static ?string $navigationGroup = 'تیکت ها ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('title')->required(),
                    // Select::make('parent_id')->label(__('Parent'))
                    //         ->options(TicketCategory::pluck('title', 'id')),
                    BelongsToSelect::make('parent_id')
                        ->relationship('parent', 'title'),
                    RichEditor::make('message')->label(__('Message'))
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
                TextColumn::make('category')
                    ->label(__('Category'))
                    ->getStateUsing(function (Ticket $record) {
                        return $record->category->title ?? null;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_id')
                    ->label(__('User'))
                    ->getStateUsing(function (Ticket $record) {
                        return $record->user->name ?? null;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->label(__('Message'))
                    ->searchable()
                    ->sortable(),

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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }


}
