<?php

namespace App\Http\Controllers\TelegramController;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules\Password;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Language
{
    public function language(Api $t, Update $u)
    {
        $text = st()->languageText;
        $text .= $this->flashMassage();
        $r = $t->editMessageText([
                                  'chat_id' => $u->getChat()->id,
                                  'message_id' => $this->getLastMessageId(),
                                  'text' => $text,
                                  'reply_markup' => $this->languageKeyboard(),
                                 ]);
    }

    public function languageKeyboard()
    {
        $inlineButton1 = Keyboard::inlineButton([
            'text' => st()->languagePersian . '🇮🇷',
            'callback_data' => 'persianLanguage',
           ]);
        $inlineButton2 = Keyboard::inlineButton([
            'text' => st()->languageEnglish . '🇬🇧',
            'callback_data' => 'englishLanguage',
           ]);

        return Keyboard::make()->inline()
                ->row($inlineButton1, $inlineButton2);
    }

    public function persianLanguage(Api $t, Update $u)
    {
        auth()->user()?->update(['lang' => 'fa']);
        App::setLocale( 'fa' );

        $text = st()->languageTextSuccess;
        $text .= $this->flashMassage();

        $r = $t->editMessageText([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => Keyboard::make()->inline()
                    ->row(Keyboard::inlineButton([
                    'text' => __('Menu'),
                    'callback_data' => 'startBack',
                ])),
        ]);
    }

    public function englishLanguage(Api $t, Update $u)
    {
        auth()->user()?->update(['lang' => 'en']);
        App::setLocale( 'en' );

        $text = st()->languageTextSuccess;
        $text .= $this->flashMassage();

        $r = $t->editMessageText([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => Keyboard::make()->inline()
                    ->row(Keyboard::inlineButton([
                    'text' => __('Menu'),
                    'callback_data' => 'startBack',
                ])),
        ]);
    }
}
