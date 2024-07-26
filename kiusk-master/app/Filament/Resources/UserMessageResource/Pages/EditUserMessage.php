<?php

namespace App\Filament\Resources\UserMessageResource\Pages;

use App\Filament\Resources\UserMessageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditUserMessage extends EditRecord
{
    protected static string $resource = UserMessageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->record->logs()->create([
            'created_by' => $this->record->user_id,
            'updated_by' => Auth::id(),
        ]);
    }
}
