<?php

namespace App\Filament\Resources\ServiceUsageResource\Pages;

use App\Filament\Resources\ServiceUsageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceUsages extends ListRecords
{
    protected static string $resource = ServiceUsageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
