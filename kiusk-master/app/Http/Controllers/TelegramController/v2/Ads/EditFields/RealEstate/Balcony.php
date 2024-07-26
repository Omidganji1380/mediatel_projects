<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Keyboard\Keyboard;

trait Balcony
{
    public function adsEditBalconyRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $text = st()->realEstateEditKeyboard[14]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsEditBalconydRequestKeyboard(),
        ]);
    }

    public function adsEditBalconydRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        $b = Keyboard::inlineButton([
            'text' => $this->lang ? "بله" : "Yes",
            'callback_data' => 'adsEditBalconyStore' . 1,
        ]);
        $b2 = Keyboard::inlineButton([
            'text' => $this->lang ? "خیر" : "No",
            'callback_data' => 'adsEditBalconyStore' . 0,
        ]);
        if (auth()->user()->extra?->adsEdit?->page == 'first_page') {
            $back = 'realEstateEditFirstPage';
        } elseif (auth()->user()->extra?->adsEdit?->page == 'second_page') {
            $back = 'realEstateEditSecondPage';
        } else {
            $back = 'realEstateEdit';
        }
        $br = Keyboard::inlineButton([
            'text' => $this->lang ? "بازگشت" : "Return",
            'callback_data' => $back,
        ]);
        return $keyboard->row($b, $b2)
            ->row($br);
    }

    public function adsEditBalconyStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $response): void
    {
        $this->updateUserExtra(function ($x) use ($message, $response) {
            $x->adsEdit->balcony = $response;
            return $x;
        });

        if (auth()->user()->extra?->adsEdit?->type == 'jobs') {
            $this->jobsEdit($telegram, $update);
        } elseif (auth()->user()->extra?->adsEdit?->type == 'real_estate') {
            if (auth()->user()->extra?->adsEdit?->page == 'first_page') {
                $this->realEstateEditFirstPage($telegram, $update);
            } elseif (auth()->user()->extra?->adsEdit?->page == 'second_page') {
                $this->realEstateEditSecondPage($telegram, $update);
            } else {
                $this->realEstateEdit($telegram, $update);
            }
        } else {
            $this->adsEditOptions($telegram, $update, $message);
        }
    }
}
