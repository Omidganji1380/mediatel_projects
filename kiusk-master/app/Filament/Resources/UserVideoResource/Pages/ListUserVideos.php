<?php

namespace App\Filament\Resources\UserVideoResource\Pages;

use App\Filament\Resources\UserVideoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserVideos extends ListRecords
{
    protected static string $resource = UserVideoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
