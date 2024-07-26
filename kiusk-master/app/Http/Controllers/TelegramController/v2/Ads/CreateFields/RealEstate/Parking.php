<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Parking
{
    public function adsCreateParkingRequest(
        Api $telegram,
        Update $update,
        Message|Collection|EditedMessage $message,
    ): void {
        $this->setLanguage();
        $text = st()->realEstateCreateKeyboard[16]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateParkingRequestKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsCreateParkingStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $facilityId): void
    {
        $this->updateUserExtra(function ($x) use ($message, $facilityId) {
            if (!isset($x->parking)) {
                $x->adsCreate->parking = [];
            }

            $x->adsCreate->parking[] = $facilityId;

            Log::info(json_encode($x->adsCreate->parking));
            return $x;
        });
        $this->adsCreateParkingRequest($telegram, $update, $message);
    }

    public function adsCreateParkingRequestKeyboard(): Keyboard
    {
        $type = auth()->user()->extra?->adsCreate?->type ?? 'jobs';
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Ad\Facility::where('type', 'parking')
            ->each(function ($item) use ($keyboard) {
                $b = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item->fa_name : $item->en_name)  . ($this->facilityCheck($item->id, 'parking') ? '✔️' : ''),
                    'callback_data' => 'adsCreateParkingStore' . $item->id,
                ]);
                $keyboard->row($b);
            });
        $b = $this->facilityConfirmButton('adsCreateFacilityRequest');
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
