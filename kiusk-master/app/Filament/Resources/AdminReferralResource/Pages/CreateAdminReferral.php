<?php

namespace App\Filament\Resources\AdminReferralResource\Pages;

use App\Filament\Resources\AdminReferralResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateAdminReferral extends CreateRecord
{
    protected static string $resource = AdminReferralResource::class;

    public function mount() : void
    {
        $this->form->fill([
            'code' => Str::random(15),
        ]);
    }
}
