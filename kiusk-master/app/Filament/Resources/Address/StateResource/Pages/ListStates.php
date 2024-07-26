<?php

namespace App\Filament\Resources\Address\StateResource\Pages;

use App\Filament\Resources\Address\StateResource;
use App\Models\Address\State;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\LinkAction;

class ListStates extends ListRecords
{
 protected static string $resource = StateResource::class;

 protected function getTableActions(): array
 {
  return [
   ...$this->getResourceTable()
           ->getActions(),
   LinkAction::make('show')
             ->label(__('admin.show'))
             ->url(fn(State $record): string => route('front.ad.category.city.index.first.page', $record->slug)),
  ];
 }
}
