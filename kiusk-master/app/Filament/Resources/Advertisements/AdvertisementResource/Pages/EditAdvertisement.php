<?php

namespace App\Filament\Resources\Advertisements\AdvertisementResource\Pages;

use App\Filament\Resources\Advertisements\AdvertisementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvertisement extends EditRecord
{
    protected static string $resource = AdvertisementResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
