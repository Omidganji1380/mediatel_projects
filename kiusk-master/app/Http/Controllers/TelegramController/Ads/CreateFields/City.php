<?php

namespace App\Http\Controllers\TelegramController\Ads\CreateFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait City
{
    public function adsCreateCityRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        if (! isset(auth()->user()->extra->adsCreate->state_id)) {
            $msg = auth()?->user()?->isLangFa() ? 'قبل از انتخاب شهر باید استان مشخص باشد.' : 'Select a state before selecting a city.';
            $this->errorMessage($msg);
            $this->adsCreate($t, $u);
        } else {
            $r = $t->editMessageText([
                                      'chat_id' => $u->getChat()->id,
                                      'message_id' => $this->getLastMessageId(),
                                      'text' => st()->adsCreateKeyboard[5]['keyText'],
                                      'reply_markup' => $this->adsCreateCityRequestKeyboard(),
                                     ]);
        }
    }

    public function adsCreateCityStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $cityId): void
    {
        $this->updateUserExtra(function ($x) use ($m, $cityId) {
            $x->adsCreate->city_id = $cityId;

            return $x;
        });
        $this->adsCreate($t, $u);
    }

    public function adsCreateCityRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
                            ->inline();
        \App\Models\Address\City::whereStateId(auth()->user()->extra->adsCreate->state_id)
                                ->get()
                                ->each(function ($ad) use ($keyboard) {
                                    $inlineButton = Keyboard::inlineButton([
                                                                            'text' => $ad->name,
                                                                            'callback_data' => 'adsCreateCityStore' . $ad->id,
                                                                           ]);
                                    $keyboard->row($inlineButton);
                                });
        $b = Keyboard::inlineButton([
                                     'text' => auth()?->user()?->isLangFa() ? 'بازگشت' : 'Return',
                                     'callback_data' => 'adsCreate',
                                    ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
