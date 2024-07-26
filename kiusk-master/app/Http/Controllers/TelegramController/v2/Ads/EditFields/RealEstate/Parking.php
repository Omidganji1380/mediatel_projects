<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Parking
{
    public function adsEditParkingRequest(
        Api $telegram,
        Update $update,
        Message|Collection|EditedMessage $message,
    ): void {
        $this->setLanguage();
        $text = st()->realEstateEditKeyboard[16]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsEditParkingRequestKeyboard(),
        ]);
    }

    public function adsEditParkingStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $facilityId): void
    {
        $this->updateUserExtra(function ($x) use ($message, $facilityId) {
            if(!isset($x->adsEdit->parking)){
                $x->adsEdit->parking = [];
            }
            if (in_array($facilityId, $x->adsEdit->parking)) {
                $x->adsEdit->parking = array_filter($x->adsEdit->parking, function ($value) use ($facilityId) {
                    return $value != $facilityId;
                });
            }else{
                $x->adsEdit->parking[] = $facilityId;
            }
            $x->adsEdit->parking = array_unique($x->adsEdit->parking);
            return $x;
        });
        $this->adsEdit($telegram, $update);
    }

    public function adsEditParkingRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Ad\Facility::where('type', 'parking')
            ->each(function ($item) use ($keyboard) {
                $b = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item->fa_name : $item->en_name)  . ($this->facilityCheck($item->id, 'parking', 'adsEdit') ? '✅' : ''),
                    'callback_data' => 'adsEditParkingStore' . $item->id,
                ]);
                $keyboard->row($b);
            });
        $b = Keyboard::inlineButton([
            'text' => $this->lang ? "بازگشت" : "Return",
            'callback_data' => 'adsEdit',
        ]);
        $keyboard = $keyboard->row($b);
        return $keyboard;
    }
}
