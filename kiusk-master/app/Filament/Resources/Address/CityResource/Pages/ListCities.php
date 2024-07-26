<?php

namespace App\Filament\Resources\Address\CityResource\Pages;

use App\Filament\Resources\Address\CityResource;
use App\Models\Address\City;
use App\Models\Address\State;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\LinkAction;

class ListCities extends ListRecords
{
 protected static string $resource = CityResource::class;

 protected function getTableActions(): array
 {
  return [
   ...$this->getResourceTable()
           ->getActions(),
   LinkAction::make('show')
             ->label(__('admin.show'))
             ->url(fn(City $record): string => route('front.ad.category.city.index.first.page', $record->slug)),
  ];
 }
}
