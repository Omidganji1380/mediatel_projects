<?php

namespace App\Http\Controllers\TelegramController\Ads;

use App\Models\Ad\Ad;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Index
{
    public function adsList(Api $t, Update $u, Message|Collection|EditedMessage $m, $page = 1)
    {
        $this->updateUserExtra(function ($x) use ($page) {
            $x->listLastPage = $page;

            return $x;
        });
        $whereUserId = Ad::whereUserId(auth()->id());
        $adsCount = $whereUserId->count();
        $perPage = 5;
        $ads = $whereUserId->forPage($page, $perPage)
                           ->get();
        $keyboard = Keyboard::make()
                            ->inline();
        $ads->each(function ($ad) use ($keyboard) {
            $title = auth()?->user()?->isLangFa() ? $ad->title : $ad->title_en ;
            if (! $ad->is_visible) {
                $title .= st()->adsListIsNotVisible;
            }
            $inlineButton = Keyboard::inlineButton([
                                                    'text' => $title,
                                                    'callback_data' => 'adsEdit' . $ad->id,
                                                   ]);
            $keyboard->row($inlineButton);
        });
        $this->pagination($ads, $adsCount, $perPage, $page, $keyboard);
        $inlineButton = Keyboard::inlineButton([
                                                'text' => st()->adsListBack,
                                                'callback_data' => 'startBack',
                                               ]);
        $keyboard->row($inlineButton);
        $text = $adsCount ? st()->adsListText : st()->adsListTextEmpty;
        $text .= $this->flashMassage();
        //  // dump($text);
        $response = $t->editMessageText([
                                         'chat_id' => $u->getChat()->id,
                                         'message_id' => $this->getLastMessageId(),
                                         'text' => $text,
                                         'reply_markup' => $keyboard,
                                        ]);
    }

    public function adsListBackToIt(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        if (isset(auth()->user()->extra->listLastPage)) {
            $page = auth()->user()->extra->listLastPage;
        } else {
            $page = 1;
        }
        $this->adsList($t, $u, $m, $page);
    }
}
