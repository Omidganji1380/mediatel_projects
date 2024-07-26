<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Floor
{
    public function adsCreateFloorRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateCreateKeyboard[15]['keyText'], 'adsCreateFloor', null, 'realEstateCreateFirstPage');
    }

    public function adsCreateFloorStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsCreateFloor', 'floor', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => 'numeric|' . st()->realEstateCreateKeyboard[15]['keyRule'],
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsCreate->floor = $message->text;

                return $x;
            });
        },
        null,
        'adsCreateAvailabilityDateRequest'
        );
    }
}
