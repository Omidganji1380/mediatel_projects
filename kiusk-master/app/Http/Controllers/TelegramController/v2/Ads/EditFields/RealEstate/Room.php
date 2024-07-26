<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Room
{
    public function adsEditRoomRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateEditKeyboard[0]['keyText'], 'adsEditRoom', null, 'realEstateEditFirstPage');
    }

    public function adsEditRoomStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsEditRoom', 'rooms', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => st()->realEstateEditKeyboard[0]['keyRule'],
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsEdit->rooms = $message->text;

                return $x;
            });
            $this->adsEdit($telegram, $update);
        });
    }
}
