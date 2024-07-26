<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\PreviewFields;

use App\Models\Ad\Ad;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Price
{
    public function adsPreviewPriceRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[2]['keyText'], 'adsPreviewPrice');
    }

    public function adsPreviewPriceStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsPreviewPrice', 'price', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->adsCreateKeyboard[2]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->price = $m->text;
                return $x;
            });
            $this->adsPreview($t, $u);
        });
    }
}
