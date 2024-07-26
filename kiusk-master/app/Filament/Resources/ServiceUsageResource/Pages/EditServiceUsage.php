<?php

namespace App\Filament\Resources\ServiceUsageResource\Pages;

use App\Events\ScoreEvent;
use App\Filament\Resources\ServiceUsageResource;
use App\Notifications\User\StatusNotification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceUsage extends EditRecord
{
    protected static string $resource = ServiceUsageResource::class;

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
                ScoreEvent::dispatch($this->record->user, 'service_usage');
        }
    }
}
