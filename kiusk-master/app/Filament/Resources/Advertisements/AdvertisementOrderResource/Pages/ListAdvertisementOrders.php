<?php

namespace App\Filament\Resources\Advertisements\AdvertisementOrderResource\Pages;

use App\Filament\Resources\Advertisements\AdvertisementOrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvertisementOrders extends ListRecords
{
    protected static string $resource = AdvertisementOrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
