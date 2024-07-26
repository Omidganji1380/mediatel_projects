<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait AvailabilityDate
{
    public function adsCreateAvailabilityDateRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateCreateKeyboard[9]['keyText'], 'adsCreateAvailabilityDate', null, 'realEstateCreateSecondPage');
    }

    public function adsCreateAvailabilityDateStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsCreateAvailabilityDate', 'availability_date', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => st()->realEstateCreateKeyboard[9]['keyRule'] . '|date_format:Y-m-d|after_or_equal:today',
            ],[
                'date_format' => __('validation.availablility_date_format'),
                'after_or_equal' =>  __('validation.availablility_date_after_or_equal_today')
            ],[
                'availability_date' => __('Availability Date')
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsCreate->availability_date = $message->text;

                return $x;
            });
        },
        null,
        'adsCreateRoomRequest'
        );
    }
}
