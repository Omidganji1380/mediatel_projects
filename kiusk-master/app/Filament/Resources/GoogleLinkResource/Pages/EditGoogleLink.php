<?php

namespace App\Filament\Resources\GoogleLinkResource\Pages;

use App\Filament\Resources\GoogleLinkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGoogleLink extends EditRecord
{
    protected static string $resource = GoogleLinkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
