<?php

namespace App\Filament\Resources\Tickets\TicketResource\Pages;

use App\Filament\Resources\Tickets\TicketResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.tickets.pages.view-ticket';

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    // protected function getFormSchema(): array
    // {
    //     return [
    //         DescriptionList::make('overview')
    //             ->items([
    //                 'Name' => $this->user->name,
    //                 'Email' => $this->user->email,
    //             ]),
    //     ];
    // }
}
