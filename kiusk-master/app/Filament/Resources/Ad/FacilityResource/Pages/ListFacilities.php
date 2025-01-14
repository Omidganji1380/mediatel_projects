<?php

namespace App\Filament\Resources\Ad\FacilityResource\Pages;

use App\Filament\Resources\Ad\FacilityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFacilities extends ListRecords
{
    protected static string $resource = FacilityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
