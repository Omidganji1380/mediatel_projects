<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\TicketResource\Pages\ReplyTicket;
use App\Filament\Resources\Tickets\TicketResource\Pages;
use App\Filament\Resources\Tickets\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
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
                        return $record->user?->name_with_role;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->label(__('Message'))
                    ->searchable()
                    ->sortable(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('reply')
                    ->label(__('admin.reply'))
                    ->mountUsing(fn (Forms\ComponentContainer $form) => $form->fill([
                        'parentTicket' => 12,
                    ]))
                    ->url(fn (Ticket $record): string => route('filament.resources.tickets.reply', $record)),
                    // ->openUrlInNewTab(),
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
            'index' => Pages\ListTickets::route('/'),
            // 'create' => Pages\CreateTicket::route('/create'),
            // 'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
            'reply' => ReplyTicket::route('/{record}/reply') // filament.resources.tickets.reply
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->parentList();
    }

    protected function getActions(): array
    {
        return [

        ];
    }
}
