<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (Hash::check('', $data['password'])) {
            unset($data['password']);
        }
        return parent::mutateFormDataBeforeSave($data);
    }

    protected function afterSave(): void
    {
        $this->record->syncRole($this->rule);
    }
}
