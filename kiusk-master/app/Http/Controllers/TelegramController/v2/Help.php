<?php

namespace App\Http\Controllers\TelegramController\v2;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Help
{
    public function help(Api $t, Update $u)
    {
        // $text = "Help Text";
        $text = st()->helpText;
        $this->sendMessageText($t, $u, $text);
    }
}
