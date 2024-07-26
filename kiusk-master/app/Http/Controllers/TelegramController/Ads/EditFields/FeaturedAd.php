<?php

namespace App\Http\Controllers\TelegramController\Ads\EditFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait FeaturedAd
{
    public function adsEditIsFeaturedRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $text = st()->adsEditKeyboard[13]['keyText'];
        $r = $t->editMessageText([
                                  'chat_id' => $u->getChat()->id,
                                  'message_id' => $this->getLastMessageId(),
                                  'text' => $text,
                                  'reply_markup' => $this->adsEditIsFeaturedRequestKeyboard(),
                                 ]);
    }

    public function adsEditIsFeaturedStoreYes(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->updateUserExtra(function ($x) use ($m) {
            $x->adsEdit->is_featured = 1;

            return $x;
        });
        $this->adsEdit($t, $u);
    }

    public function adsEditIsFeaturedStoreNo(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->updateUserExtra(function ($x) use ($m) {
            $x->adsEdit->is_featured = 0;

            return $x;
        });
        $this->adsEdit($t, $u);
    }

    public function adsEditIsFeaturedRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
                            ->inline();
        $b = Keyboard::inlineButton([
                'text' => auth()->user()->isLangFa() ? "بله" : "Yes",
                'callback_data' => 'adsEditIsFeaturedStoreYes',
            ]);
        $b2 = Keyboard::inlineButton([
                'text' => auth()->user()->isLangFa() ? "خیر" : "No",
                'callback_data' => 'adsEditIsFeaturedStoreNo',
            ]);
        $br = Keyboard::inlineButton([
                                     'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
                                     'callback_data' => 'adsEdit',
                                    ]);

        return $keyboard->row($b, $b2)
                        ->row($br);
    }
}
