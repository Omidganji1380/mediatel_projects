<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Area
{
    public function adsCreateAreaRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateCreateKeyboard[3]['keyText'], 'adsCreateArea', null, 'realEstateCreateSecondPage');
    }

    public function adsCreateAreaStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsCreateArea', 'area', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => 'numeric|' . st()->realEstateCreateKeyboard[3]['keyRule'],
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsCreate->area = $message->text;

                return $x;
            });
        },
        null,
        'adsCreateAreaUnitRequest'
        );
    }
}
