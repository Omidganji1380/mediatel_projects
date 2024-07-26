<?php

namespace App\Filament\Resources\Tickets\TicketCategoryResource\Pages;

use App\Filament\Resources\Tickets\TicketCategoryResource;
use Filament\Resources\Pages\ListRecords;

class ListTicketCategories extends ListRecords
{
    protected static string $resource = TicketCategoryResource::class;
}
