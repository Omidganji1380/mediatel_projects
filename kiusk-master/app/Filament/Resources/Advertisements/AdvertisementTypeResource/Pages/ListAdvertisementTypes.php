<?php

namespace App\Filament\Resources\Advertisements\AdvertisementTypeResource\Pages;

use App\Filament\Resources\Advertisements\AdvertisementTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvertisementTypes extends ListRecords
{
    protected static string $resource = AdvertisementTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
