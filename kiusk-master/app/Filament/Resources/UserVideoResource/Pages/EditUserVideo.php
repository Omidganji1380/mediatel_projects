<?php

namespace App\Filament\Resources\UserVideoResource\Pages;

use App\Events\ScoreEvent;
use App\Filament\Resources\UserVideoResource;
use App\Notifications\User\StatusNotification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserVideo extends EditRecord
{
    protected static string $resource = UserVideoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.
        if($this->data['message']){
            $this->record->user?->notify(new StatusNotification($this->data['message']));
        }
        if($this->data['is_confirmed']){
            if($this->record)
                ScoreEvent::dispatch($this->record->user, 'send_video');
        }
    }
}
