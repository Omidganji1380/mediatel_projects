<?php

namespace App\Filament\Resources\AdminReferralResource\Pages;

use App\Filament\Resources\AdminReferralResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminReferrals extends ListRecords
{
    protected static string $resource = AdminReferralResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
