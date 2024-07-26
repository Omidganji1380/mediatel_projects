<?php

namespace App\Http\Controllers\TelegramController\Ads\EditFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Content
{

    public function adsEditContentRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestEdit($t, $u, $m, st()->adsEditKeyboard[3]['keyText'], 'adsEditContent');
    }

    public function adsEditContentStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsEditContent', 'content', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
             $data => st()->adsEditKeyboard[3]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsEdit->content = $m->text;
                $x->adsEdit->content_strip = $m->text;

                return $x;
            });
            $this->adsEdit($t, $u);
        });
    }

    public function adsEditContentEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestEdit($t, $u, $m, st()->adsEditKeyboard[3]['keyText'], 'adsEditContentEn');
    }

    public function adsEditContentEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsEditContentEn', 'content_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
             $data => st()->adsEditKeyboard[3]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsEdit->content_en = $m->text;
                // $x->adsEdit->content_strip = $m->text;

                return $x;
            });
            $this->adsEdit($t, $u);
        });
    }
}
