<?php

namespace App\Filament\Resources\GoogleLinkResource\Pages;

use App\Filament\Resources\GoogleLinkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGoogleLinks extends ListRecords
{
    protected static string $resource = GoogleLinkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
