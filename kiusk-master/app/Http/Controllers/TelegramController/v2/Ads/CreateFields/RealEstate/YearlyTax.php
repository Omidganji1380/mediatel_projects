<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait YearlyTax
{
    public function adsCreateYearlyTaxRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateCreateKeyboard[6]['keyText'], 'adsCreateYearlyTax', null, 'realEstateCreateSecondPage');
    }

    public function adsCreateYearlyTaxStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsCreateYearlyTax', 'yearly_tax', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => 'numeric|' . st()->realEstateCreateKeyboard[6]['keyRule'],
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsCreate->yearly_tax = $message->text;

                return $x;
            });
        },
        null,
        'adsCreateKeepingPriceRequest'
        );
    }
}
