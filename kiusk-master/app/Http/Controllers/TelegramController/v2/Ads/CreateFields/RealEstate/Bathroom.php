<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Bathroom
{
    public function adsCreateBathroomRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateCreateKeyboard[5]['keyText'], 'adsCreateBathroom', null,'realEstateCreateFirstPage');
    }

    public function adsCreateBathroomStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsCreateBathroom', 'bathroom', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => 'numeric|' . st()->realEstateCreateKeyboard[5]['keyRule'],
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsCreate->bathroom = $message->text;

                return $x;
            });
        },
        null,
        'adsCreateParkingRequest'
        );
    }
}
