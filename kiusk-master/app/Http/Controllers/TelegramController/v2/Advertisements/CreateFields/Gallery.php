<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Gallery
{
    public function advertisementsCreateGalleryRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->deleteLastRequest($t, $u);
        $this->setLanguage();

        $return = Keyboard::button([
            'text' => auth()?->user()?->isLangFa() ? 'بازگشت' : 'Return',
        ]);
        $keyboard = Keyboard::make()
            ->row($return);
        $text = __('messages.advertisements.send_image');
        $text .= $this->flashMassage();
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
        $this->updateLastRequestId($r->messageId);

        auth()
            ->user()
            ->update([
                'telegram_last_message' => $text,
                'telegram_last_method' => 'advertisementsCreateGalleryStore',
                'telegram_next_method' => 'advertisementsCreateContentRequest',
            ]);
        $this->updateLastMessage($text);
    }

    public function advertisementsCreateGalleryStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $user = auth()->user();
        $keyRule = 1;
        if ($m->has('photo')) {
            if (
                $user->getMedia('advertisementsCreateGallery') && $user->getMedia('advertisementsCreateGallery')
                ->count() <= (int)$keyRule
            ) {
                $file = $t->getFile([
                    'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
                ]);
                $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
                $user->addMediaFromUrl($fileUrl)
                    ->toMediaCollection('advertisementsCreateGallery');
                $t->sendMessage([
                    'chat_id' => $u->getChat()->id,
                    'message_id' => $m->messageId,
                    'text' => __('Image saved successfully.'),
                    'reply_markup' => $this->returnToHomeKeyboard()
                ]);
                session()->put('numberGalleryAddOne', true);
                $this->advertisementsCreateGalleryEnRequest($t, $u, $m);
            } else {
                $this->errorMessage(__('validation.telegram_image_count', ['count' => $keyRule]));
            }
        } else {
            $msg = __('validation.gallery_type');
            $this->errorMessage($msg);
            $this->advertisementsCreateGalleryRequest($t, $u, $m);
        }
    }

    public function advertisementsCreateGalleryEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->deleteLastRequest($t, $u);
        $this->setLanguage();

        $return = Keyboard::button([
            'text' => auth()?->user()?->isLangFa() ? 'بازگشت' : 'Return',
        ]);
        $keyboard = Keyboard::make()
            ->row($return);
        $text = __('messages.advertisements.send_image_en');
        $text .= $this->flashMassage();
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
        $this->updateLastRequestId($r->messageId);

        auth()
            ->user()
            ->update([
                'telegram_last_message' => $text,
                'telegram_last_method' => 'advertisementsCreateGalleryEnStore',
                'telegram_next_method' => 'advertisementsCreateContentRequest',
            ]);
        $this->updateLastMessage($text);
    }

    public function advertisementsCreateGalleryEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $user = auth()->user();
        $keyRule = 1;
        if ($m->has('photo')) {
            if (
                $user->getMedia('advertisementsCreateGalleryEn') && $user->getMedia('advertisementsCreateGalleryEn')
                ->count() <= (int)$keyRule
            ) {
                $file = $t->getFile([
                    'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
                ]);
                $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
                $user->addMediaFromUrl($fileUrl)
                    ->toMediaCollection('advertisementsCreateGalleryEn');
                $t->sendMessage([
                    'chat_id' => $u->getChat()->id,
                    'message_id' => $m->messageId,
                    'text' => __('Image saved successfully.'),
                    'reply_markup' => $this->returnToHomeKeyboard()
                ]);
                session()->put('numberGalleryAddOne', true);
                $this->advertisementsCreateContentRequest($t, $u, $m);
            } else {
                $this->errorMessage(__('validation.telegram_image_count', ['count' => $keyRule]));
            }
        } else {
            $msg = __('validation.gallery_type');
            $this->errorMessage($msg);
            $this->advertisementsCreateGalleryEnRequest($t, $u, $m);
        }
    }

    public function advertisementsCreateGalleryRemoveAll(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $user = auth()->user();
        $user->clearMediaCollection('advertisementsCreateGallery');
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => __('Images deleted successfully.')
        ]);
        $this->advertisementsCreateGalleryRequest($t, $u, $m);
    }
}
