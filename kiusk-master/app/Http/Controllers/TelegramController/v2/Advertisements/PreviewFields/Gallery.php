<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\PreviewFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Gallery
{
    public function advertisementsPreviewGalleryRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->deleteLastRequest($t, $u);
        $b = Keyboard::button([
            'text' => auth()?->user()?->isLangFa() ? 'پاک‌ کردن همه عکس‌ها' : 'Clear all images',
            //  'callback_data' => 'advertisementsCreateGalleryRemoveAll',
        ]);
        $c = Keyboard::button([
            'text' => auth()?->user()?->isLangFa() ? 'بازگشت' : 'Return',
            //  'callback_data' => 'advertisementsCreate',
        ]);
        $keyboard = Keyboard::make()
            // ->inline()
            ->row($b)
            ->row($c);
        $text = 'required';
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
        $this->updateLastRequestId($r->messageId);
        // $r = $t->editMessageText([
        //                           'chat_id' => $u->getChat()->id,
        //                           'message_id' => $this->getLastMessageId(),
        //                           'text' => $text,
        //                           'reply_markup' => $keyboard,
        //                          ]);
        auth()
            ->user()
            ->update([
                'telegram_last_message' => $text,
                'telegram_last_method' => 'advertisementsPreviewGalleryStore',
            ]);
        $this->updateLastMessage($text);
    }

    public function advertisementsPreviewGalleryStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $user = auth()->user();
        $ketRule = 'required';
        if ($user->getMedia('advertisementsCreateGallery') && $user->getMedia('advertisementsCreateGallery')
            ->count() < (int)$ketRule
        ) {
            $file = $t->getFile([
                'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
            ]);
            $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
            $user->addMediaFromUrl($fileUrl)
                ->toMediaCollection('advertisementsCreateGallery');
            $t->deleteMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $m->messageId,
            ]);
        } else {
            $msg = auth()?->user()?->isLangFa() ? "تعداد عکس ها حداکثر ${ketRule} عدد باید باشد." : "Number of images must be ${ketRule}";
            $this->errorMessage($msg);
        }
        session()->put('numberGalleryAddOne', true);
        // $this->advertisementsCreate($t, $u);
        //  $this->updateLastMessage();
        $this->advertisementsPreview($t, $u, $m);
    }

    public function advertisementsPreviewGalleryRemoveAll(Api $t, Update $u, Message|Collection|EditedMessage $m)
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
