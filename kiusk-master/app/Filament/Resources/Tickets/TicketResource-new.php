<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\Tickets\TicketResource\Pages;
use App\Filament\Resources\Tickets\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('parent_id')
                    ->hidden(function(Ticket $ticket){
                        return $ticket->parent_id == null;
                    }),
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->schema([
                    Card::make()->schema([
                        TextInput::make('title')->required(),
                        // Select::make('parent_id')->label(__('Parent'))
                        //         ->options(TicketCategory::pluck('title', 'id')),
                        // BelongsToSelect::make('parent_id')
                        //     ->relationship('parent', 'title'),
                        RichEditor::make('message')->label(__('Message'))
                    ])
                ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTickets::route('/'),
            'view' => Pages\ViewTicket::route('/{record}'),
        ];
    }
}
