<?php

namespace App\Http\Controllers\TelegramController\Ads\CreateFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Content
{
    public function adsCreateContentRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[3]['keyText'], 'adsCreateContent');
    }

    public function adsCreateContentStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsCreateContent', 'content', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
             $data => st()->adsCreateKeyboard[3]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->content = $m->text;

                return $x;
            });
            $this->adsCreate($t, $u);
        });
    }

    public function adsCreateContentEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[10]['keyText'], 'adsCreateContentEn');
    }

    public function adsCreateContentEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsCreateContentEn', 'content_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
             $data => st()->adsCreateKeyboard[10]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->content_en = $m->text;

                return $x;
            });
            $this->adsCreate($t, $u);
        });
    }
}
