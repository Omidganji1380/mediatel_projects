<?php

namespace App\Http\Controllers\TelegramController\Ads\CreateFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Keyboard\Keyboard;

trait FeaturedAd
{
    public function adsCreateIsFeaturedRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $text = st()->adsCreateKeyboard[11]['keyText'];
        $r = $t->editMessageText([
                                  'chat_id' => $u->getChat()->id,
                                  'message_id' => $this->getLastMessageId(),
                                  'text' => $text,
                                  'reply_markup' => $this->adsCreateIsFeaturedRequestKeyboard(),
                                 ]);
    }

    public function adsCreateIsFeaturedStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $response): void
    {
        $this->updateUserExtra(function ($x) use ($m, $response) {
            $x->adsCreate->is_featured = $response;
            return $x;
        });
        $this->adsCreate($t, $u);
    }

    public function adsCreateIsFeaturedRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
                            ->inline();
        $b = Keyboard::inlineButton([
                'text' => auth()->user()->isLangFa() ? "بله" : "Yes",
                'callback_data' => 'adsCreateIsFeaturedStore' . 1,
            ]);
        $b2 = Keyboard::inlineButton([
                'text' => auth()->user()->isLangFa() ? "خیر" : "No",
                'callback_data' => 'adsCreateIsFeaturedStore' . 0,
            ]);
        $br = Keyboard::inlineButton([
                                     'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
                                     'callback_data' => 'adsCreate',
                                    ]);
        return $keyboard->row($b, $b2)
                        ->row($br);
    }
}
