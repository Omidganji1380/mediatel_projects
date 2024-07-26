<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements;

use App\Models\Ad\Ad;
use App\Models\TelegramAd;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Index
{
    public function advertisementsList(Api $t, Update $u, Message|Collection|EditedMessage $m, $page = 1)
    {
        $this->updateUserExtra(function ($x) use ($page) {
            $x->listLastPage = $page;

            return $x;
        });
        $whereUserId = TelegramAd::whereUserId(auth()->id());
        $advertisementsCount = $whereUserId->count();
        $perPage = 5;
        $advertisements = $whereUserId->forPage($page, $perPage)
            ->get();
        $keyboard = Keyboard::make()
            ->inline();

        $advertisements->each(function ($ad) use ($keyboard) {
            $title = auth()?->user()?->isLangFa() ? $ad->description : $ad->description_en;
            if (!$ad->is_approved) {
                $title .= st()->adsListIsNotVisible;
            }
            $inlineButton = Keyboard::inlineButton([
                'text' => $title,
                'callback_data' => 'advertisementsEdit' . $ad->id,
            ]);
            $keyboard->row($inlineButton);
        });
        $this->pagination($advertisements, $advertisementsCount, $perPage, $page, $keyboard);
        $inlineButton = Keyboard::inlineButton([
            'text' => st()->adsListBack,
            'callback_data' => 'startBack',
        ]);
        $keyboard->row($inlineButton);
        $text = $advertisementsCount ? st()->adsListText : st()->adsListTextEmpty;
        $text .= $this->flashMassage();
        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);

        $this->updateLastRequestId($response->messageId);
    }

    public function advertisementsListBackToIt(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        if (isset(auth()->user()->extra->listLastPage)) {
            $page = auth()->user()->extra->listLastPage;
        } else {
            $page = 1;
        }
        $this->advertisementsList($t, $u, $m, $page);
    }

    public function inlineAdvertisementsList(Api $t, Update $u, Message|Collection|EditedMessage $m, $page = 1)
    {
        $this->updateUserExtra(function ($x) use ($page) {
            $x->listLastPage = $page;

            return $x;
        });
        $whereUserId = TelegramAd::whereUserId(auth()->id());
        $advertisementsCount = $whereUserId->count();
        $perPage = 5;
        $advertisements = $whereUserId->forPage($page, $perPage)
            ->get();
        $keyboard = Keyboard::make()
            ->inline();
        $advertisements->each(function ($ad) use ($keyboard) {
            $title = auth()?->user()?->isLangFa() ? $ad->description : $ad->description_en;
            if (!$ad->is_visible) {
                $title .= st()->adsListIsNotVisible;
            }
            $inlineButton = Keyboard::inlineButton([
                'text' => $title,
                'callback_data' => 'advertisementsEdit' . $ad->id,
            ]);
            $keyboard->row($inlineButton);
        });
        $this->pagination($advertisements, $advertisementsCount, $perPage, $page, $keyboard);
        $inlineButton = Keyboard::inlineButton([
            'text' => st()->adsListBack,
            'callback_data' => 'startBack',
        ]);
        $keyboard->row($inlineButton);
        $text = $advertisementsCount ? st()->adsListText : st()->adsListTextEmpty;
        $text .= $this->flashMassage();
        //  // dump($text);
        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
    }

    public function inlineAdvertisementsListBackToIt(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        if (isset(auth()->user()->extra->listLastPage)) {
            $page = auth()->user()->extra->listLastPage;
        } else {
            $page = 1;
        }
        $this->advertisementsList($t, $u, $m, $page);
    }
}
