<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait UnitFacility
{
    public function adsCreateUnitFacilityRequest(
        Api $telegram,
        Update $update,
        Message|Collection|EditedMessage $message,
    ): void {
        $this->setLanguage();
        $text = st()->realEstateCreateKeyboard[13]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateUnitFacilityRequestKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsCreateUnitFacilityStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $facilityId): void
    {
        $this->updateUserExtra(function ($x) use ($message, $facilityId) {
            if(!isset($x->adsCreate->unit_facilities)){
                $x->adsCreate->unit_facilities = [];
            }
            $x->adsCreate->unit_facilities[] = $facilityId;
            return $x;
        });
        $this->adsCreateUnitFacilityRequest($telegram, $update, $message);
    }

    public function adsCreateUnitFacilityRequestKeyboard(): Keyboard
    {
        $type = auth()->user()->extra?->adsCreate?->type ?? 'jobs';
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Ad\Facility::where('type', 'unit_facility')
            ->chunk(2, function ($item) use ($keyboard) {
                $button1 = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item[0]->fa_name : $item[0]->en_name)  . ($this->facilityCheck($item[0]->id, 'unit_facilities') ? '✔️' : ''),
                    'callback_data' => 'adsCreateUnitFacilityStore' . $item[0]?->id,
                ]);
                if(isset($item[1])){
                    $button2 = Keyboard::inlineButton([
                        'text' => ($this->lang == 'fa' ? $item[1]->fa_name : $item[1]->en_name)  . ($this->facilityCheck($item[1]->id, 'unit_facilities') ? '✔️' : ''),
                        'callback_data' => 'adsCreateUnitFacilityStore' . $item[1]->id,
                    ]);
                    $keyboard->row($button1, $button2);
                }else{
                    $keyboard->row($button1);
                }
            });
        $b = $this->facilityConfirmButton('realEstateLastStep');
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
