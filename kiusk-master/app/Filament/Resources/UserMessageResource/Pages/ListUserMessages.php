<?php

namespace App\Filament\Resources\UserMessageResource\Pages;

use App\Filament\Resources\UserMessageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserMessages extends ListRecords
{
    protected static string $resource = UserMessageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
