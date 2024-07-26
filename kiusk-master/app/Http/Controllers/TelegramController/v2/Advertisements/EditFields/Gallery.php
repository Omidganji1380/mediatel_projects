<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\EditFields;

use Arr;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Gallery
{
    public function advertisementsEditGalleryRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $b = Keyboard::inlineButton([
            'text' => __('Remove all images'),
            'callback_data' => 'advertisementsEditGalleryRemoveAll'
        ]);
        $c = Keyboard::inlineButton([
            'text' => __('Return'),
            'callback_data' => 'advertisementsEdit'
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            // ->row($b)
            ->row($c);
        $text = __('messages.advertisements.edit_gallery_en_text');
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard
        ]);
        auth()
            ->user()
            ->update([
                'telegram_last_message' => $text,
                'telegram_last_method' => 'advertisementsEditGalleryStore',
            ]);
    }

    public function advertisementsEditGalleryStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $user = auth()->user();
        $keyRule = 1;
        if ($user->getMedia('advertisementsEditGallery') && $user->getMedia('advertisementsEditGallery')
            ->count() <= $keyRule
        ) {
            $file = $t->getFile([
                'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
            ]);
            $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
            $user->addMediaFromUrl($fileUrl)
                ->toMediaCollection('advertisementsEditGallery');
            $t->deleteMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $m->messageId,
            ]);
        } else {
            $this->errorMessage(__('validation.telegram_image_count', ['count' => $keyRule]));
        }
        session()->put('numberGalleryAddOne', true);
        $this->advertisementsEdit($t, $u);
    }

    public function advertisementsEditGalleryEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $b = Keyboard::inlineButton([
            'text' => __('Remove all images'),
            'callback_data' => 'advertisementsEditGalleryEnRemoveAll'
        ]);
        $c = Keyboard::inlineButton([
            'text' => __('Return'),
            'callback_data' => 'advertisementsEdit'
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            // ->row($b)
            ->row($c);
        $text = __('messages.advertisements.edit_gallery_text');
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard
        ]);
        auth()
            ->user()
            ->update([
                'telegram_last_message' => $text,
                'telegram_last_method' => 'advertisementsEditGalleryEnStore',
            ]);
    }

    public function advertisementsEditGalleryEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $user = auth()->user();
        $keyRule = 1;
        if ($user->getMedia('advertisementsEditGalleryEn') && $user->getMedia('advertisementsEditGalleryEn')
            ->count() <= $keyRule
        ) {
            $file = $t->getFile([
                'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
            ]);
            $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
            $user->addMediaFromUrl($fileUrl)
                ->toMediaCollection('advertisementsEditGalleryEn');
            $t->deleteMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $m->messageId,
            ]);
        } else {
            $this->errorMessage(__('validation.telegram_image_count', ['count' => $keyRule]));
        }
        session()->put('numberGalleryAddOne', true);
        $this->advertisementsEdit($t, $u);
    }

    public function advertisementsEditGalleryRemoveAll(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $user = auth()->user();
        $user->clearMediaCollection('advertisementsEditGallery');
        $this->advertisementsEdit($t, $u);
    }
}
