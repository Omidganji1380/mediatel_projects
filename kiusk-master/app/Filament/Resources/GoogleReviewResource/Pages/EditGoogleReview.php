<?php

namespace App\Filament\Resources\GoogleReviewResource\Pages;

use App\Filament\Resources\GoogleReviewResource;
use App\Notifications\User\StatusNotification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGoogleReview extends EditRecord
{
    protected static string $resource = GoogleReviewResource::class;

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
    }
}
