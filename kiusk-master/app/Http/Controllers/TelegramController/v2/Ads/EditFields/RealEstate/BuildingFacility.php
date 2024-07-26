<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;


trait BuildingFacility
{
    public function adsEditBuildingFacilityRequest(
        Api $telegram,
        Update $update,
        Message|Collection|EditedMessage $message,
    ): void {
        $this->setLanguage();
        $text = st()->realEstateEditKeyboard[12]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsEditBuildingFacilityRequestKeyboard(),
        ]);
    }

    public function adsEditBuildingFacilityStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $facilityId): void
    {
        $this->updateUserExtra(function ($x) use ($message, $facilityId) {
            if(!isset($x->adsEdit->building_facilities)){
                $x->adsEdit->building_facilities = [];
            }
            $x->adsEdit->building_facilities[] = $facilityId;
            return $x;
        });
        $this->adsEdit($telegram, $update);
    }

    public function adsEditBuildingFacilityRequestKeyboard(): Keyboard
    {
        $type = auth()->user()->extra?->adsEdit?->type ?? 'jobs';
        $keyboard = Keyboard::make()
            ->inline();

        \App\Models\Ad\Facility::where('type', 'building_facility')
            ->chunk(2, function ($item) use ($keyboard) {
                $button1 = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item[0]->fa_name : $item[0]->en_name)  . ($this->facilityCheck($item[0]->id, 'building_facilities', 'adsEdit') ? '✔️' : ''),
                    'callback_data' => 'adsEditBuildingFacilityStore' . $item[0]?->id,
                ]);
                if(isset($item[1])){
                    $button2 = Keyboard::inlineButton([
                        'text' => ($this->lang == 'fa' ? $item[1]->fa_name : $item[1]->en_name)  . ($this->facilityCheck($item[1]->id, 'building_facilities', 'adsEdit') ? '✔️' : ''),
                        'callback_data' => 'adsEditBuildingFacilityStore' . $item[1]->id,
                    ]);
                    $keyboard->row($button1, $button2);
                }else{
                    $keyboard->row($button1);
                }
            });
        $b = $this->facilityConfirmButton('adsEdit');
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
