<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait City
{
 public function adsEditCityRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
 {
  if (!isset(auth()->user()->extra->adsEdit->state_id)) {
   $this->errorMessage('قبل از انتخاب شهر باید استان مشخص باشد.');
   $this->adsEdit($t, $u);
  }
  else
   $r = $t->sendMessage([
                             'chat_id' => $u->getChat()->id,
                             'message_id' => $this->getLastMessageId(),
                             'text' => st()->adsEditKeyboard[5]['keyText'],
                             'reply_markup' => $this->adsEditCityRequestKeyboard()
                            ]);
 }

 public function adsEditCityStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $cityId): void
 {
  $this->updateUserExtra(function ($x) use ($m, $cityId) {
   $x->adsEdit->city_id = $cityId;
   return $x;
  });
  $this->adsEdit($t, $u);
 }

 public function adsEditCityRequestKeyboard(): Keyboard
 {
  $keyboard = Keyboard::make()
                      ->inline();
  \App\Models\Address\City::whereStateId(auth()->user()->extra->adsEdit->state_id)
                          ->get()
                          ->each(function ($ad) use ($keyboard) {
                           $inlineButton = Keyboard::inlineButton([
                                                                   'text' => $ad->name,
                                                                   'callback_data' => 'adsEditCityStore' . $ad->id
                                                                  ]);
                           $keyboard->row($inlineButton);
                          });
  $b = Keyboard::inlineButton([
                               'text' => 'بازگشت',
                               'callback_data' => 'adsEdit'
                              ]);
  $keyboard = $keyboard->row($b);
  return $keyboard;
 }
}
