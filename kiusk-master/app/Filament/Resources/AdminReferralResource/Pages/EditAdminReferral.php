<?php

namespace App\Filament\Resources\AdminReferralResource\Pages;

use App\Filament\Resources\AdminReferralResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminReferral extends EditRecord
{
    protected static string $resource = AdminReferralResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
