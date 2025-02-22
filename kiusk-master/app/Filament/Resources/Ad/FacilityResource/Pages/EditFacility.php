<?php

namespace App\Filament\Resources\Ad\FacilityResource\Pages;

use App\Filament\Resources\Ad\FacilityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFacility extends EditRecord
{
    protected static string $resource = FacilityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
