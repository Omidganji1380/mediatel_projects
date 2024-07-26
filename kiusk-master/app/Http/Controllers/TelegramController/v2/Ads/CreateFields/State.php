<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait State
{
    public function adsCreateStateRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $text = st()->adsCreateKeyboard[6]['keyText'];
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateStateRequestKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function returnToAdsCreateStateRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->deleteLastRequest($t, $u);
        $text = st()->adsCreateKeyboard[6]['keyText'];
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateStateRequestKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsCreateStateStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $stateId): void
    {
        $this->updateUserExtra(function ($x) use ($m, $stateId) {
            $x->adsCreate->state_id = $stateId;
            unset($x->adsCreate->city_id);

            return $x;
        });
        $this->adsCreateCityRequest($t, $u, $m);
    }

    public function adsCreateStateRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        // $states = \App\Models\Address\State::all();
        //     ->each(function ($ad) use ($keyboard) {
        //         $button = Keyboard::inlineButton([
        //             'text' => $ad->name,
        //             'callback_data' => 'adsCreateStateStore' . $ad->id,
        //         ]);
        //         $keyboard->row($button);
        //     });
        \App\Models\Address\State::chunk(2, function ($chunk) use ($keyboard) {
            $button1 = Keyboard::inlineButton([
                'text' => $chunk[0]?->name,
                'callback_data' => 'adsCreateStateStore' . $chunk[0]?->id,
            ]);
            if(isset($chunk[1])){
                $button2 = Keyboard::inlineButton([
                    'text' => $chunk[1]->name,
                    'callback_data' => 'adsCreateStateStore' . $chunk[1]->id,
                ]);
                $keyboard->row($button1, $button2);
            }else{
                $keyboard->row($button1);
            }
        });
        $b = Keyboard::inlineButton([
            'text' => auth()?->user()?->isLangFa() ? 'بازگشت' : 'Return',
            'callback_data' => 'adsCreate',
        ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
