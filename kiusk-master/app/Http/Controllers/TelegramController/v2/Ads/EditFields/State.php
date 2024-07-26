<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait State
{
 public function adsEditStateRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
 {
  $text = st()->adsEditKeyboard[6]['keyText'];
  $r = $t->sendMessage([
                            'chat_id' => $u->getChat()->id,
                            'message_id' => $this->getLastMessageId(),
                            'text' => $text,
                            'reply_markup' => $this->adsEditStateRequestKeyboard()
                           ]);
  $user = auth()->user();
  $user->update([
                 'telegram_last_message' => $text,
                 'telegram_last_method' => 'adsEditStateStore',
                ]);
 }

 public function adsEditStateStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $stateId): void
 {
  // dump('222222222222');
  $this->updateUserExtra(function ($x) use ($m, $stateId) {
   $x->adsEdit->state_id = $stateId;
   unset($x->adsEdit->city_id);
   return $x;
  });
  $this->adsEdit($t, $u);
 }

 public function adsEditStateRequestKeyboard(): Keyboard
 {
  $keyboard = Keyboard::make()
                      ->inline();
  \App\Models\Address\State::all()
                           ->each(function ($ad) use ($keyboard) {
                            $inlineButton = Keyboard::inlineButton([
                                                                    'text' => $ad->name,
                                                                    'callback_data' => 'adsEditStateStore' . $ad->id
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
