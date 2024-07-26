<?php

namespace App\Filament\Resources\Tickets\TicketResource\Pages;

use App\Filament\Resources\Tickets\TicketResource;
use App\Models\Ticket;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\LinkAction;
use Illuminate\Database\Query\Builder;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getTableActions(): array
    {
        return [
            // Action::make('edit')
            //     ->label('Reply')
            //     ->url(fn (Ticket $record): string => route('tickets.edit', $record))
            ...$this->getResourceTable()
            ->getActions(),
            LinkAction::make('reply')
                        ->label(__('Reply'))
                        ->url(fn(Ticket $record): string => route('front.ad.show', $record->id)),
        ];
    }
}
