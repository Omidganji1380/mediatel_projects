<?php

namespace App\Http\Controllers\TelegramController\Ads;

use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;

trait AcceptTheRules
{
 public function adsAcceptTheRules(Api $t, Update $u): void
 {
  $keyboad = Keyboard::make()
                     ->inline()
                     ->row(Keyboard::inlineButton([
                                                   'text' => st()->adsAcceptTheRulesKeyName,
                                                   'callback_data' => 'adsCreate'
                                                  ]));
  $r = $t->editMessageText([
                            'chat_id' => $u->getChat()->id,
                            'message_id' => $this->getLastMessageId(),
                            'text' => st()->adsAcceptTheRulesText,
                            'parse_mode' => 'Markdown',
                            'reply_markup' => $keyboad
                           ]);
  $user = auth()->user();
  $x = $user->extra ?? new stdClass();
  $x->adsAcceptTheRulesMessageId = $r->messageId;
  $user->update(['extra' => $x,]);
 }
}
