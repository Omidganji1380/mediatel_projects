<?php

namespace App\Filament\Resources\Ad\ReviewResource\Pages;

use App\Events\ScoreEvent;
use App\Filament\Resources\Ad\ReviewResource;
use App\Notifications\User\StatusNotification;
use Filament\Resources\Pages\EditRecord;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.
        if(isset($this->data['message'])){
            $this->record->user?->notify(new StatusNotification($this->data['message']));
        }
        if(isset($this->data['is_visible'])){
            if($this->record)
                ScoreEvent::dispatch($this->record->user, 'review');
        }
    }
}
