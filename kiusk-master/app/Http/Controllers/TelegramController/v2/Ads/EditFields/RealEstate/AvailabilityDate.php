<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait AvailabilityDate
{
    public function adsEditAvailabilityDateRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateEditKeyboard[9]['keyText'], 'adsEditAvailabilityDate');
    }

    public function adsEditAvailabilityDateStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsEditAvailabilityDate', 'availability_date', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => 'date_format:Y-m-d|' . st()->realEstateEditKeyboard[9]['keyRule'],
            ], [
                'date_format' => __('validation.availablility_date_format'),
                'after_or_equal' =>  __('validation.availablility_date_after_or_equal_today')
            ], [
                'availability_date' => __('Availability Date')
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsEdit->availability_date = $message->text;

                return $x;
            });
            $this->adsEdit($telegram, $update);
        });
    }
}
