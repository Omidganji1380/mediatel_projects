<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait MainFacility
{
    public function adsEditFacilityRequest(
        Api $telegram,
        Update $update,
        Message|Collection|EditedMessage $message,
        $parenFacility = null
    ): void {
        $this->setLanguage();
        $text = st()->realEstateEditKeyboard[10]['keyText'];
        $r = $telegram->sendMessage([
            'chat_id' => $update->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsEditFacilityRequestKeyboard($parenFacility),
        ]);
    }

    public function adsEditFacilityStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message, $facilityId): void
    {
        $this->updateUserExtra(function ($x) use ($message, $facilityId) {
            if(!isset($x->adsEdit->facilities)){
                $x->adsEdit->facilities = [];
            }
            $x->adsEdit->facilities[] = $facilityId;
            return $x;
        });
        $this->adsEditFacilityRequest($telegram, $update, $message);
    }

    public function adsEditFacilityRequestKeyboard($parenFacility): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Ad\Facility::where('type', 'facility')
            ->chunk(2, function ($item) use ($keyboard) {
                $button1 = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item[0]->fa_name : $item[0]->en_name)  . ($this->facilityCheck($item[0]->id, 'facilities', 'adsEdit') ? '✔️' : ''),
                    'callback_data' => 'adsEditFacilityStore' . $item[0]?->id,
                ]);
                if(isset($item[1])){
                    $button2 = Keyboard::inlineButton([
                        'text' => ($this->lang == 'fa' ? $item[1]->fa_name : $item[1]->en_name)  . ($this->facilityCheck($item[1]->id, 'facilities', 'adsEdit') ? '✔️' : ''),
                        'callback_data' => 'adsEditFacilityStore' . $item[1]->id,
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
