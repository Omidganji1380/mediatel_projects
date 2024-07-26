<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait ConstructionYear
{
    public function adsEditConstructionYearRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateEditKeyboard[8]['keyText'], 'adsEditConstructionYear');
    }

    public function adsEditConstructionYearStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsEditConstructionYear', 'construction_year', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => st()->realEstateEditKeyboard[8]['keyRule'] . "|date_format:Y|max:" . now()->year,
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsEdit->construction_year = $message->text;

                return $x;
            });
            $this->adsEdit($telegram, $update);
        });
    }
}
