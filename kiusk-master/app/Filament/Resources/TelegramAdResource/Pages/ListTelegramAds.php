<?php

namespace App\Filament\Resources\TelegramAdResource\Pages;

use App\Filament\Resources\TelegramAdResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTelegramAds extends ListRecords
{
    protected static string $resource = TelegramAdResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
