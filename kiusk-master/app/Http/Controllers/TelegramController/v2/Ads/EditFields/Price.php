<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields;

use App\Models\Ad\Ad;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Price
{
 public function adsEditPriceRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
 {
  $this->requestEdit($t, $u, $m, st()->adsEditKeyboard[2]['keyText'], 'adsEditPrice');
 }

 public function adsEditPriceStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
 {
  $this->store($t, $u, $m, 'adsEditPrice', 'price', function ($t, $u, $m, $data) {
   return \Validator::make([$data => $m->text], [
    $data => st()->adsEditKeyboard[2]['keyRule'],
   ]);
  }, function ($t, $u, $m) {
   $this->updateUserExtra(function ($x) use ($m) {
    $x->adsEdit->price = $m->text;
    return $x;
   });
   $this->adsEdit($t, $u);
  });
 }
}
