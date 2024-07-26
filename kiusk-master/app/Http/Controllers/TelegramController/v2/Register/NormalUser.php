<?php

namespace App\Http\Controllers\TelegramController\v2\Register;

use Str;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait NormalUser
{
    public function registerNormalUser(Api $t, Update $u): void
    {
        // $text = st()->registerText;
        $text = st()->registerNormalUserText;
        $this->sharePhone($t, $u);
    }

    public function registerNormalUserGuide(Api $t, Update $u): void
    {
        // $text = "Normal User Guide Text";
        $text = st()->registerNormalUserGuideText;
        $this->sendMessageText($t, $u, $text);
    }
}
