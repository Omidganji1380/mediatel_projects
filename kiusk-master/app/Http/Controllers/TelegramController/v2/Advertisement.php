<?php

namespace App\Http\Controllers\TelegramController\v2;

use App\Http\Controllers\TelegramController\v2\Advertisements\AcceptTheRules;
use App\Http\Controllers\TelegramController\v2\Advertisements\Create;
use App\Http\Controllers\TelegramController\v2\Advertisements\Edit;
use App\Http\Controllers\TelegramController\v2\Advertisements\Index;
use App\Http\Controllers\TelegramController\v2\Advertisements\Preview;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Advertisement
{
    use Create;
    use Edit;
    use Index;
    use AcceptTheRules;
    // use Preview;

    public function advertisement(Api $t, Update $u)
    {
        // $text = "Coming soon...";
        // $text = st()->advertismentText;
        // $this->sendMessageText($t, $u, $text);
        // $response = $t->sendMessage([
        //     'chat_id' => $u->getChat()->id,
        //     'text' => st()->startText,
        //     'reply_markup' => $this->advertisementKeyboard(),
        // ]);
        $text = __("For extensive advertising in Canada, enter the bot below");
        $keyboard = Keyboard::make()->inline()->row(Keyboard::inlineButton([
            'text' => __("Canada Ads Bot"),
            'url' => "https://t.me/Canadaads_bot",
        ]));

        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
    }

    public function advertisementKeyboard(): Keyboard
    {
        $inlineButton = Keyboard::button([
            'text' => __('Create Advertisement') . ' ➕',
        ]);
        $inlineButton1 = Keyboard::button([
            'text' => __('Edit Advertisement') . ' ✏️',
        ]);
        $inlineButton2 = Keyboard::button([
            'text' => __('My Advertisements') . ' 📜',
        ]);
        $inlineButton3 = Keyboard::button([
            'text' => __('Advertisement Help') . ' 👥',
        ]);
        $return = Keyboard::button([
            'text' => __('Return To Main Menu') . ' ↩️',
        ]);
        $keyboard = Keyboard::make()
            ->row($inlineButton, $inlineButton1)
            ->row($inlineButton2, $inlineButton3)
            ->row($return);

        return $keyboard;
    }

    public function advertisementHelp(Api $t, Update $u)
    {
        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => __('messages.advertisements.help'),
            'parse_mode' => 'HTML'
        ]);
    }
}

