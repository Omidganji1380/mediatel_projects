<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\EditFields;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Category
{
    public function advertisementsEditCategoryRequest(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m
    ): void {
        $text = st()->adsEditKeyboard[0]['keyText'];
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->advertisementsEditCategoryRequestKeyboard(),
        ]);
    }

    public function advertisementsEditCategoryStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $type): void
    {
        $this->updateUserExtra(function ($x) use ($m, $type) {
            $x->advertisementsEdit->ad_type = $type;

            return $x;
        });
        $this->advertisementsEdit($t, $u);
    }

    public function advertisementsEditCategoryRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        $categories = collect(\App\Models\TelegramAd::TYPES);
        $categories->each(function ($item, $key) use ($keyboard) {
            $b = Keyboard::inlineButton([
                'text' => __('messages.categories.types.' . $key),
                'callback_data' => 'advertisementsEditCategoryStore' . $key,
            ]);
            $keyboard->row($b);
        });
        $b = Keyboard::inlineButton([
            'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
            'callback_data' => 'advertisementsEdit',
        ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
