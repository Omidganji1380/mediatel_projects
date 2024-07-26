<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait MainFacility
{
    public function adsCreateFacilityRequest(
        Api $telegram,
        Update $update,
        Message|Collection|EditedMessage $message,
        $parenFacility = null
    ): void {
        $this->setLanguage();
        $text = st()->realEstateCreateKeyboard[10]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateFacilityRequestKeyboard($parenFacility),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsCreateFacilityStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $facilityId): void
    {
        $this->updateUserExtra(function ($x) use ($message, $facilityId) {
            if(!isset($x->adsCreate->facilities)){
                $x->adsCreate->facilities = [];
            }
            $x->adsCreate->facilities[] = $facilityId;
            return $x;
        });
        $this->adsCreateFacilityRequest($telegram, $update, $message);
    }

    public function adsCreateFacilityRequestKeyboard($parenFacility): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        // \App\Models\Ad\Facility::where('type', 'facility')
        //     ->each(function ($item) use ($keyboard, $parenFacility) {
        //         $b = Keyboard::inlineButton([
        //             'text' => ($this->lang == 'fa' ? $item->fa_name : $item->en_name)  . ($this->facilityCheck($item->id, 'facilities') ? '✔️' : ''),
        //             'callback_data' => 'adsCreateFacilityStore' . $item->id,
        //         ]);
        //         $keyboard->row($b);
        //     });
        \App\Models\Ad\Facility::where('type', 'facility')
            ->chunk(2, function ($item) use ($keyboard) {
                $button1 = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item[0]->fa_name : $item[0]->en_name)  . ($this->facilityCheck($item[0]->id, 'facilities') ? '✔️' : ''),
                    'callback_data' => 'adsCreateFacilityStore' . $item[0]?->id,
                ]);
                if(isset($item[1])){
                    $button2 = Keyboard::inlineButton([
                        'text' => ($this->lang == 'fa' ? $item[1]->fa_name : $item[1]->en_name)  . ($this->facilityCheck($item[1]->id, 'facilities') ? '✔️' : ''),
                        'callback_data' => 'adsCreateFacilityStore' . $item[1]->id,
                    ]);
                    $keyboard->row($button1, $button2);
                }else{
                    $keyboard->row($button1);
                }
            });
        $b = $this->facilityConfirmButton('adsCreateNearbyFacilityRequest');
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
