<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Keyboard\Keyboard;

trait Balcony
{
    public function adsCreateBalconyRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $text = st()->realEstateCreateKeyboard[13]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateBalconydRequestKeyboard(),
        ]);
    }

    public function adsCreateBalconydRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        $b = Keyboard::inlineButton([
            'text' => $this->lang ? "بله" : "Yes",
            'callback_data' => 'adsCreateBalconyStore' . 1,
        ]);
        $b2 = Keyboard::inlineButton([
            'text' => $this->lang ? "خیر" : "No",
            'callback_data' => 'adsCreateBalconyStore' . 0,
        ]);
        if (auth()->user()->extra?->adsCreate?->page == 'first_page') {
            $back = 'realEstateCreateFirstPage';
        } elseif (auth()->user()->extra?->adsCreate?->page == 'second_page') {
            $back = 'realEstateCreateSecondPage';
        } else {
            $back = 'realEstateCreate';
        }
        $br = Keyboard::inlineButton([
            'text' => $this->lang ? "بازگشت" : "Return",
            'callback_data' => $back,
        ]);
        return $keyboard->row($b, $b2)
            ->row($br);
    }

    public function adsCreateBalconyStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $response): void
    {
        $this->updateUserExtra(function ($x) use ($message, $response) {
            $x->adsCreate->balcony = $response;
            return $x;
        });

        if (auth()->user()->extra?->adsCreate?->type == 'jobs') {
            $this->jobsCreate($telegram, $update);
        } elseif (auth()->user()->extra?->adsCreate?->type == 'real_estate') {
            if (auth()->user()->extra?->adsCreate?->page == 'first_page') {
                $this->realEstateCreateFirstPage($telegram, $update);
            } elseif (auth()->user()->extra?->adsCreate?->page == 'second_page') {
                $this->realEstateCreateSecondPage($telegram, $update);
            } else {
                $this->realEstateCreate($telegram, $update);
            }
        } else {
            $this->adsCreateOptions($telegram, $update, $message);
        }
    }
}
