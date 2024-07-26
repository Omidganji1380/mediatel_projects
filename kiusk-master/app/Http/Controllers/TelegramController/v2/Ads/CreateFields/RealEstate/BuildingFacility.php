<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;


trait BuildingFacility
{
    public function adsCreateBuildingFacilityRequest(
        Api $telegram,
        Update $update,
        Message|Collection|EditedMessage $message,
    ): void {
        $this->setLanguage();
        $text = st()->realEstateCreateKeyboard[12]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateBuildingFacilityRequestKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsCreateBuildingFacilityStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $facilityId): void
    {
        $this->updateUserExtra(function ($x) use ($message, $facilityId) {
            if(!isset($x->adsCreate->building_facilities)){
                $x->adsCreate->building_facilities = [];
            }
            $x->adsCreate->building_facilities[] = $facilityId;
            return $x;
        });

        $this->adsCreateBuildingFacilityRequest($telegram, $update, $message);
    }

    public function adsCreateBuildingFacilityRequestKeyboard(): Keyboard
    {
        $type = auth()->user()->extra?->adsCreate?->type ?? 'jobs';
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Ad\Facility::where('type', 'building_facility')
            ->chunk(2, function ($item) use ($keyboard) {
                $button1 = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item[0]->fa_name : $item[0]->en_name)  . ($this->facilityCheck($item[0]->id, 'building_facilities') ? '✔️' : ''),
                    'callback_data' => 'adsCreateBuildingFacilityStore' . $item[0]?->id,
                ]);
                if(isset($item[1])){
                    $button2 = Keyboard::inlineButton([
                        'text' => ($this->lang == 'fa' ? $item[1]->fa_name : $item[1]->en_name)  . ($this->facilityCheck($item[1]->id, 'building_facilities') ? '✔️' : ''),
                        'callback_data' => 'adsCreateBuildingFacilityStore' . $item[1]->id,
                    ]);
                    $keyboard->row($button1, $button2);
                }else{
                    $keyboard->row($button1);
                }
            });
        $b = $this->facilityConfirmButton('adsCreateUnitFacilityRequest');
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
