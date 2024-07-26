<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\PreviewFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait City
{
    public function adsPreviewCityRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        if (!isset(auth()->user()->extra->adsCreate->state_id)) {
            $msg = auth()?->user()?->isLangFa() ? 'قبل از انتخاب شهر باید استان مشخص باشد.' : 'Select a state before selecting a city.';
            $this->errorMessage($msg);
            $this->adsCreateStateRequest($t, $u, $m);
        } else {
            $this->deleteLastRequest($t, $u);
            $r = $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => st()->adsCreateKeyboard[5]['keyText'],
                'reply_markup' => $this->adsCreateCityRequestKeyboard(),
            ]);
            $this->updateLastRequestId($r->messageId);
        }
    }

    public function adsPreviewCityStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $cityId): void
    {
        $this->updateUserExtra(function ($x) use ($m, $cityId) {
            $x->adsCreate->city_id = $cityId;

            return $x;
        });
        $this->adsPreview($t, $u, $m);
    }

    public function adsPreviewCityRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Address\City::whereStateId(auth()->user()->extra->adsCreate->state_id)->chunk(2, function ($chunk) use ($keyboard) {
            $button1 = Keyboard::inlineButton([
                'text' => $chunk[0]?->name,
                'callback_data' => 'adsPreviewCityStore' . $chunk[0]?->id,
            ]);
            if(isset($chunk[1])){
                $button2 = Keyboard::inlineButton([
                    'text' => isset($chunk[1]) ? $chunk[1]->name : '',
                    'callback_data' => isset($chunk[1]) ? 'adsPreviewCityStore' . $chunk[1]->id : '',
                ]);
                $keyboard->row($button1, $button2);
            }else{
                $keyboard->row($button1);
            }
        });
        $b = Keyboard::inlineButton([
            'text' => auth()?->user()?->isLangFa() ? 'بازگشت' : 'Return',
            'callback_data' => 'returnToAdsPreviewStateRequest',
        ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
