<?php

namespace App\Http\Controllers\TelegramController;

use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;

trait Start
{
    //start
    public function start(Api $t, Update $u): void
    {
        // $t->sendPhoto([
        //     'chat_id' => $u->getChat()->id,
        //     'photo' => InputFile::create(public_path('/' . "images/nowruz.jpg"), 'welcome.png'),
        // ]);
        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => st()->startText,
            'reply_markup' => $this->startKeyboard(),
        ]);
        $this->updateLastMessageId($response->messageId);
    }

    public function startRemoveKeyboard(Api $t, Update $u): void
    {
        // $t->sendPhoto([
        //     'chat_id' => $u->getChat()->id,
        //     'photo' => InputFile::create(public_path('/' . "images/nowruz.jpg"), 'welcome.png'),
        // ]);
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => st()->startText,
            'reply_markup' => Keyboard::remove([
                'remove_keyboard' => true,
                'selective' => false,
            ]),
        ]);
        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => st()->startText,
            'reply_markup' => $this->startKeyboard(),
        ]);
        $this->updateLastMessageId($response->messageId);
    }

    public function startBack(Api $t, Update $u): void
    {
        $text = st()->startText;
        $text .= $this->flashMassage();
        $response = $t->editMessageText([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->startKeyboard(),
        ]);
    }

    public function startKeyboard(): Keyboard
    {
        $inlineButton = Keyboard::inlineButton([
            'text' => st()->startKeyboard[0]['keyName']  . ' 📣',
            'callback_data' => 'adsCreate',
        ]);
        $inlineButton1 = Keyboard::inlineButton([
            'text' => (auth()->user()->phone ? '✅' : '❌') . st()->startKeyboard[1]['keyName'] . ' 👨‍💻',
            'callback_data' => 'register',
        ]);
        $inlineButton2 = Keyboard::inlineButton([
            'text' => st()->startKeyboard[2]['keyName'] . ' 📂',
            'callback_data' => 'adsList',
        ]);
        $inlineButton3 = Keyboard::inlineButton([
            'text' => st()->startKeyboard[3]['keyName'] . ' 👤',
            'callback_data' => 'profile',
        ]);
        $inlineButton4 = Keyboard::inlineButton([
            'text' => st()->startKeyboard[4]['keyName'] . ' 🌐',
            'callback_data' => 'language',
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($inlineButton, $inlineButton1)
            ->row($inlineButton2, $inlineButton3)
            ->row($inlineButton4);

        return $keyboard;
    }
}
