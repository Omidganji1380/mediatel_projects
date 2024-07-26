<?php

namespace App\Filament\Resources\Blog\PostResource\Pages;

use App\Filament\Resources\Blog\PostResource;
use App\Models\Address\State;
use App\Models\Blog\Post;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\LinkAction;

class ListPosts extends ListRecords
{
 protected static string $resource = PostResource::class;

 protected function getTableActions(): array
 {
  return [
   ...$this->getResourceTable()
           ->getActions(),
   LinkAction::make('show')
             ->label(__('admin.show'))
             ->url(fn(Post $record): string => $record->link),
  ];
 }
}
