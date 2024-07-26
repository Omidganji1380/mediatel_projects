<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Title
{
    public function adsEditTitleRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestEdit($t, $u, $m, st()->adsEditKeyboard[1]['keyText'], 'adsEditTitle');
    }

    public function adsEditTitleStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsEditTitle', 'title', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
             $data => ['min:3',
            //   Rule::unique('ads', 'title')
            //       ->ignore(auth()->user()->extra->adsEdit->id),
             ],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                // dump($x->adsEdit);
                $x->adsEdit->title = $m->text;

                return $x;
            });
            $this->adsEdit($t, $u);
        });
    }


    public function adsEditTitleEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestEdit($t, $u, $m, st()->adsEditKeyboard[11]['keyText'], 'adsEditTitleEn');
    }

    public function adsEditTitleEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsEditTitleEn', 'title_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
             $data => ['min:3',
            //   Rule::unique('ads', 'title_en')
            //       ->ignore(auth()->user()->extra->adsEdit->id),
             ],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                // dump($x->adsEdit);
                $x->adsEdit->title_en = $m->text;

                return $x;
            });
            $this->adsEdit($t, $u);
        });
    }
}
