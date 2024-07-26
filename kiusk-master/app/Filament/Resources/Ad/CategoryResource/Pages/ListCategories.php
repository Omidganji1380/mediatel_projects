<?php

namespace App\Filament\Resources\Ad\CategoryResource\Pages;

use App\Filament\Resources\Ad\CategoryResource;
use App\Models\Ad\Category;
use App\Models\Address\State;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\LinkAction;

class ListCategories extends ListRecords
{
 protected static string $resource = CategoryResource::class;

 protected function getTableActions(): array
 {
  return [
   ...$this->getResourceTable()
           ->getActions(),
   LinkAction::make('show')
             ->label(__('admin.show'))
             ->url(fn(Category $record): string => route('front.ad.category.index.first.page', $record->slug)),
  ];
 }
}
