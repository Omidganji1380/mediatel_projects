<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait ConstructionYear
{
    public function adsCreateConstructionYearRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateCreateKeyboard[8]['keyText'], 'adsCreateConstructionYear', null, 'realEstateCreateSecondPage');
    }

    public function adsCreateConstructionYearStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsCreateConstructionYear', 'construction_year', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => 'numeric|' . st()->realEstateCreateKeyboard[8]['keyRule'] . '|max:' . now()->year,
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsCreate->construction_year = $message->text;

                return $x;
            });
        },
        null,
        'adsCreateFloorRequest'
        );
    }
}
