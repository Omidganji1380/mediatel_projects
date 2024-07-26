<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Floor
{
    public function adsEditFloorRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateEditKeyboard[15]['keyText'], 'adsEditFloor');
    }

    public function adsEditFloorStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsEditFloor', 'floor', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => st()->realEstateEditKeyboard[15]['keyRule'],
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsEdit->floor = $message->text;

                return $x;
            });
            $this->adsEdit($telegram, $update);
        });
    }
}
