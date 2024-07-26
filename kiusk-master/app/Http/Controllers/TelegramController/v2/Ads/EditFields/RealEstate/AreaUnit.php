<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use App\Models\Ad\RealEstateDetail;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Keyboard\Keyboard;

trait AreaUnit
{
    public function adsEditAreaUnitRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->setLanguage();
        $text = st()->realEstateEditKeyboard[4]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsEditAreaUnitdRequestKeyboard(),
        ]);
    }

    public function adsEditAreaUnitdRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        $b = Keyboard::inlineButton([
            'text' => __('messages.area_unit.square_feet'),
            'callback_data' => 'adsEditAreaUnitStore' . 0,
        ]);
        $b2 = Keyboard::inlineButton([
            'text' => __('messages.area_unit.square_meter'),
            'callback_data' => 'adsEditAreaUnitStore' . 1,
        ]);

        $br = Keyboard::inlineButton([
            'text' => $this->lang ? "بازگشت" : "Return",
            'callback_data' => 'adsEdit',
        ]);
        return $keyboard->row($b)
            ->row($b2)
            ->row($br);
    }

    public function adsEditAreaUnitStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $response): void
    {
        $this->updateUserExtra(function ($x) use ($message, $response) {
            $x->adsEdit->area_unit = ($response === 0) ? 'square_feet' : 'square_meter';;
            return $x;
        });

        $this->adsEdit($telegram, $update);
    }
}
