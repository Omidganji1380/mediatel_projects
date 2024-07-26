<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait YearlyTax
{
    public function adsEditYearlyTaxRequest(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->request($telegram, $update, $message, st()->realEstateEditKeyboard[6]['keyText'], 'adsEditYearlyTax');
    }

    public function adsEditYearlyTaxStore(Api $telegram, Update $update, Message|Collection|EditedMessage $message): void
    {
        $this->store($telegram, $update, $message, 'adsEditYearlyTax', 'yearly_tax', function ($telegram, $update, $message, $data) {
            return \Validator::make([$data => $message->text], [
                $data => st()->realEstateEditKeyboard[6]['keyRule'],
            ]);
        }, function ($telegram, $update, $message) {
            $this->updateUserExtra(function ($x) use ($message) {
                $x->adsEdit->yearly_tax = $message->text;

                return $x;
            });
            $this->adsEdit($telegram, $update);
        });
    }
}
