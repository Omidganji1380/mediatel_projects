<?php

namespace App\Filament\Resources\UserMessageResource\Pages;

use App\Filament\Resources\UserMessageResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

class CreateUserMessage extends CreateRecord
{
    protected static string $resource = UserMessageResource::class;

    protected function afterCreate(): void
    {
        $this->record->logs()->create([
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        if($this->record->all){
            $users = User::whereNotNull('telegram_id')
            ->get();

            foreach($users as $user){
                $this->sendTelegramMessage($user->telegram_id, $this->record->message);
            }
        }else{
            if($this->record->real_estate){
                $this->sendMessage("real_estate", $this->record->message);
            }
            if($this->record->seller){
                $this->sendMessage("seller", $this->record->message);
            }
            if($this->record->business_owner){
                $this->sendMessage("business_owner", $this->record->message);
            }
            if($this->record->property_applicant){
                $this->sendMessage("property_applicant", $this->record->message);
            }
            foreach($this->data['selected_user'] as $user){
                $user = User::find($user);
                $this->sendTelegramMessage($user->telegram_id, $this->record->message);
            }
        }

    }

    protected function sendMessage($role, $message)
    {
        $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })
        ->whereNotNull('telegram_id')
        ->get();

        foreach($users as $user){
            $this->sendTelegramMessage($user->telegram_id, $message);
        }
    }

    protected function sendTelegramMessage($telegramId, $message)
    {
        $t = new Api(st()->botApiToken);
        $u = $t->getWebhookUpdate();
        $m = $u->getMessage();
        $message = str_replace("</p>", PHP_EOL, $message);
        $message = strip_tags($message, '<b><i><a><code><pre><strong><em>');
        if(env('APP_ENV') !== 'local'){

            if($this->record->getFirstMediaUrl('image')){
                $path = str_replace('\\', '/', $this->record->getFirstMedia('image')->getPath());
                $r = $t->sendPhoto([
                    'chat_id' => $telegramId,
                    'photo' => InputFile::create($path, $this->record->title ?? $telegramId),
                    'caption' => $message,
                    'parse_mode' => 'HTML'
                ]);
            }else{
                $t->sendMessage([
                    'chat_id' => $telegramId,
                    'text' => $message,
                    'parse_mode' => 'HTML'
                ]);
            }
        }else{
            Log::info('Telegram Message Id: ' . $telegramId);
            Log::info('Telegram Message: ' . $message);
        }
    }
}
