<?php

namespace App\Http\Controllers\TelegramController\Ads\CreateFields;

use App\Models\Ad\Ad;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Price
{
 public function adsCreatePriceRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
 {
  $this->request($t, $u, $m, st()->adsCreateKeyboard[2]['keyText'], 'adsCreatePrice');
 }

 public function adsCreatePriceStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
 {
  $this->store($t, $u, $m, 'adsCreatePrice', 'price', function ($t, $u, $m, $data) {
   return \Validator::make([$data => $m->text], [
    $data => st()->adsCreateKeyboard[2]['keyRule'],
   ]);
  }, function ($t, $u, $m) {
   $this->updateUserExtra(function ($x) use ($m) {
    $x->adsCreate->price = $m->text;
    return $x;
   });
   $this->adsCreate($t, $u);
  });
 }
}
