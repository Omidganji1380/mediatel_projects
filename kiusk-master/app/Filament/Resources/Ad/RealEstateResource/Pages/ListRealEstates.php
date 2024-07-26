<?php

namespace App\Filament\Resources\Ad\RealEstateResource\Pages;

use App\Filament\Resources\Ad\RealEstateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRealEstates extends ListRecords
{
    protected static string $resource = RealEstateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->whereHas('mainCategory', function ($query) {
            $query->where('type', 'real_estate');
        });
    }
}
