<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use App\Models\Ad\Ad;
use App\Models\Ad\RealEstateDetail;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Keyboard\Keyboard;

trait AreaUnit
{
    public function adsCreateAreaUnitRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->setLanguage();
        $text = st()->realEstateCreateKeyboard[4]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateAreaUnitdRequestKeyboard(),
        ]);
    }

    public function adsCreateAreaUnitdRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        $b = Keyboard::inlineButton([
            'text' => __('messages.area_unit.square_feet'),
            'callback_data' => 'adsCreateAreaUnitStore' . 0,
        ]);
        $b2 = Keyboard::inlineButton([
            'text' => __('messages.area_unit.square_meter'),
            'callback_data' => 'adsCreateAreaUnitStore' . 1,
        ]);
        return $keyboard->row($b)
            ->row($b2);
    }

    public function adsCreateAreaUnitStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $response): void
    {
        $this->updateUserExtra(function ($x) use ($message, $response) {
            $x->adsCreate->area_unit = ($response === 0) ? 'square_feet' : 'square_meter';
            return $x;
        });

        $this->adsCreateConstructionYearRequest($telegram, $update, $message);
    }
}
