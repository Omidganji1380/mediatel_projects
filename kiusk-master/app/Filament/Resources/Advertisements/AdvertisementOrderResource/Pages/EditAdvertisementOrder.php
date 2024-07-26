<?php

namespace App\Filament\Resources\Advertisements\AdvertisementOrderResource\Pages;

use App\Filament\Resources\Advertisements\AdvertisementOrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvertisementOrder extends EditRecord
{
    protected static string $resource = AdvertisementOrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
