<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait MortgagePrice
{
    public function adsCreateMortgagePriceRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateCreateKeyboard[14]['keyText'], 'adsCreateMortgagePrice', null, 'realEstateCreateSecondPage');
    }

    public function adsCreateMortgagePriceStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsCreateMortgagePrice', 'mortgage_price', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => 'numeric|' . st()->realEstateCreateKeyboard[14]['keyRule'],
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsCreate->mortgage_price = $message->text;

                return $x;
            });

        },
        null,
        'adsCreateRentPriceRequest'
        );
    }
}
