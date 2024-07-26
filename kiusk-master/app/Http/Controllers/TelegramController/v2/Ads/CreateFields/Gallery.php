<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Gallery
{
    public function adsCreateGalleryRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->deleteLastRequest($t, $u);
        $this->setLanguage();

        // $b = Keyboard::button([
        //     'text' => auth()?->user()?->isLangFa() ? 'پاک‌ کردن همه عکس‌ها' : 'Clear all images',
        //     //  'callback_data' => 'adsCreateGalleryRemoveAll',
        // ]);
        $emoji = App::isLocale('fa') ? ' ⬅️' : ' ➡️';
        $b = Keyboard::button([
            'text' => __("Skip This Step") . $emoji,
        ]);
        $c = Keyboard::button([
            'text' => auth()?->user()?->isLangFa() ? 'بازگشت' : 'Return',
        ]);
        $keyboard = Keyboard::make()
            ->row($b)
            ->row($c);
        $text = st()->adsCreateKeyboard[4]['keyText'];
        $text .= $this->flashMassage();
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
        if ($this->isTypeRealEstate()) {
            if($this->isSaleTypeRent()){
                $nextMethod = 'adsCreateMortgagePriceRequest';
            }else{
                $nextMethod = 'adsCreateSalePriceRequest';
            }
        } else {
            $nextMethod = 'lastStep';
        }
        auth()
            ->user()
            ->update([
                'telegram_last_message' => $text,
                'telegram_last_method' => 'adsCreateGalleryStore',
                'telegram_next_method' => $nextMethod,
            ]);
        $this->updateLastMessage($text);
    }

    public function adsCreateGalleryStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $user = auth()->user();
        $keyRule = st()->adsCreateKeyboard[4]['keyRule'];
        if ($m->has('photo')) {
            if (
                $user->getMedia('adsCreateGallery') && $user->getMedia('adsCreateGallery')
                ->count() < (int)$keyRule
            ) {
                $file = $t->getFile([
                    'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
                ]);
                $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
                $user->addMediaFromUrl($fileUrl)
                    ->toMediaCollection('adsCreateGallery');

                session()->put('numberGalleryAddOne', true);
                if ($this->isTypeRealEstate()) {
                    $t->sendMessage([
                        'chat_id' => $u->getChat()->id,
                        'message_id' => $m->messageId,
                        'text' => __('Image saved successfully.'),
                        'reply_markup' => $this->confirmImageKeyboard()
                    ]);
                    $this->adsCreateGalleryRequest($t, $u, $m);
                } else {
                    $t->sendMessage([
                        'chat_id' => $u->getChat()->id,
                        'message_id' => $m->messageId,
                        'text' => __('Image saved successfully.'),
                        'reply_markup' => $this->returnToHomeKeyboard()
                    ]);
                    $this->lastStep($t, $u, $m);
                }
            } else {
                $this->errorMessage(__('validation.telegram_image_count', ['count' => $keyRule]));
            }
        } else {
            $msg = __('validation.gallery_type');
            $this->errorMessage($msg);
            $this->adsCreateGalleryRequest($t, $u, $m);
        }
    }

    public function adsCreateConfirmImage(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        if($this->isSaleTypeRent()){
            $this->adsCreateMortgagePriceRequest($t, $u, $m);
        }else{
            $this->adsCreateSalePriceRequest($t, $u, $m);
        }
    }

    public function adsCreateGalleryRemoveAll(Api $t, Update $u, Message|Collection|EditedMessage $m)
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
