<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\PreviewFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Gallery
{
    public function adsPreviewGalleryRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->deleteLastRequest($t, $u);
        $b = Keyboard::button([
            'text' => auth()?->user()?->isLangFa() ? 'پاک‌ کردن همه عکس‌ها' : 'Clear all images',
            //  'callback_data' => 'adsCreateGalleryRemoveAll',
        ]);
        $c = Keyboard::button([
            'text' => auth()?->user()?->isLangFa() ? 'بازگشت' : 'Return',
            //  'callback_data' => 'adsCreate',
        ]);
        $keyboard = Keyboard::make()
            // ->inline()
            ->row($b)
            ->row($c);
        $text = st()->adsCreateKeyboard[4]['keyText'];
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
                'telegram_last_method' => 'adsPreviewGalleryStore',
            ]);
        $this->updateLastMessage($text);
    }

    public function adsPreviewGalleryStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $user = auth()->user();
        $ketRule = st()->adsCreateKeyboard[4]['keyRule'];
        if ($user->getMedia('adsCreateGallery') && $user->getMedia('adsCreateGallery')
            ->count() < (int)$ketRule
        ) {
            $file = $t->getFile([
                'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
            ]);
            $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
            $user->addMediaFromUrl($fileUrl)
                ->toMediaCollection('adsCreateGallery');
            $t->deleteMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $m->messageId,
            ]);
        } else {
            $msg = auth()?->user()?->isLangFa() ? "تعداد عکس ها حداکثر ${ketRule} عدد باید باشد." : "Number of images must be ${ketRule}";
            $this->errorMessage($msg);
        }
        session()->put('numberGalleryAddOne', true);
        // $this->adsCreate($t, $u);
        //  $this->updateLastMessage();
        $this->adsPreview($t, $u, $m);
    }

    public function adsPreviewGalleryRemoveAll(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $user = auth()->user();
        $user->clearMediaCollection('adsCreateGallery');
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => __('Images deleted successfully.')
        ]);
        $this->adsCreateGalleryRequest($t, $u, $m);
    }
}
