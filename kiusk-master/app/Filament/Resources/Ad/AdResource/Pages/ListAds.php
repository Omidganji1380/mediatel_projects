<?php

namespace App\Filament\Resources\Ad\AdResource\Pages;

use App\Filament\Resources\Ad\AdResource;
use App\Models\Ad\Ad;
use App\Models\Address\State;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\LinkAction;

class ListAds extends ListRecords
{
    protected static string $resource = AdResource::class;

    protected function getTableActions(): array
    {
        return [
            ...$this->getResourceTable()
                ->getActions(),
            LinkAction::make('show')
                ->label(__('admin.show'))
                ->url(fn (Ad $record): string => route('front.ad.show', $record->slug)),
        ];
    }
}
