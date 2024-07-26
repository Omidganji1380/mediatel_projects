<?php

namespace App\Filament\Resources\ScoreResource\Pages;

use App\Filament\Resources\ScoreResource;
use App\Mail\User\ScoreNotification;
use App\Notifications\User\StatusNotification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Swift_TransportException;

class EditScore extends EditRecord
{
    protected static string $resource = ScoreResource::class;

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
        if($this->data['claimed']){
            // Send email notification
            if($this->record?->user?->email && !Str::contains($this->record->user->email, '@telegram.telegram')){
                try {
                    Mail::to($this->record->user->email)->send(new ScoreNotification($this->record->user, $this->record->score, $this->record->type));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }
            }

        }
    }
}
