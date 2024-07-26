<?php

namespace App\Filament\Resources\Blog\CommentResource\Pages;

use App\Events\ScoreEvent;
use App\Filament\Resources\Blog\CommentResource;
use App\Notifications\User\StatusNotification;
use Filament\Resources\Pages\EditRecord;

class EditComment extends EditRecord
{
    protected static string $resource = CommentResource::class;

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.
        if($this->data['message']){
            $this->record->user?->notify(new StatusNotification($this->data['message']));
        }
        if($this->data['is_visible']){
            if($this->record)
                ScoreEvent::dispatch($this->record->user, 'comment');
        }
    }
}
