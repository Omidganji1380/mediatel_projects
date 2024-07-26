<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait NearbyFacility
{
    public function adsCreateNearbyFacilityRequest(
        Api $telegram,
        Update $update,
        Message|Collection|EditedMessage $message,
    ): void {
        $this->setLanguage();
        $text = st()->realEstateCreateKeyboard[11]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateNearbyFacilityRequestKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsCreateNearbyFacilityStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $facilityId): void
    {
        $this->updateUserExtra(function ($x) use ($message, $facilityId) {
            if(!isset($x->adsCreate->nearby_facilities)){
                $x->adsCreate->nearby_facilities = [];
            }
            $x->adsCreate->nearby_facilities[] = $facilityId;
            return $x;
        });
        $this->adsCreateNearbyFacilityRequest($telegram, $update, $message);
    }

    public function adsCreateNearbyFacilityRequestKeyboard(): Keyboard
    {
        $type = auth()->user()->extra?->adsCreate?->type ?? 'jobs';
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Ad\Facility::where('type', 'nearby_facility')
            ->chunk(2, function ($item) use ($keyboard) {
                $button1 = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item[0]->fa_name : $item[0]->en_name)  . ($this->facilityCheck($item[0]->id, 'nearby_facilities') ? '✔️' : ''),
                    'callback_data' => 'adsCreateNearbyFacilityStore' . $item[0]?->id,
                ]);
                if(isset($item[1])){
                    $button2 = Keyboard::inlineButton([
                        'text' => ($this->lang == 'fa' ? $item[1]->fa_name : $item[1]->en_name)  . ($this->facilityCheck($item[1]->id, 'nearby_facilities') ? '✔️' : ''),
                        'callback_data' => 'adsCreateNearbyFacilityStore' . $item[1]->id,
                    ]);
                    $keyboard->row($button1, $button2);
                }else{
                    $keyboard->row($button1);
                }
            });
        $b = $this->facilityConfirmButton('adsCreateBuildingFacilityRequest');
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
