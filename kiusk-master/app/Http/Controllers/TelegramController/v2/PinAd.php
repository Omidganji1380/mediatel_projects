<?php

namespace App\Http\Controllers\TelegramController\v2;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait PinAd
{
    public function pinAd(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $this->adsList($t, $u, $m);
        // $text = "Coming soon...";
        // $text = st()->pinAdText;
        // $this->sendMessageText($t, $u, $text);
    }
}
