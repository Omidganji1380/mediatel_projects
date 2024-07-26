<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Title
{
    public function adsCreateTitleRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[1]['keyText'], 'adsCreateTitle');
    }

    public function adsCreateTitleStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsCreateTitle', 'title', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->adsCreateKeyboard[1]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->title = $m->text;

                return $x;
            });
        },
        null,
        'adsCreateTitleEnRequest'
        );
        // $this->adsCreateTitleEnRequest($t, $u, $m);
    }

    public function adsCreateTitleEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[9]['keyText'], 'adsCreateTitleEn');
    }

    public function adsCreateTitleEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsCreateTitleEn', 'title_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->adsCreateKeyboard[9]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->title_en = $m->text;

                return $x;
            });
            // $this->adsCreate($t, $u);
        },
        null,
        'adsCreateContentRequest'
        );
        // $this->adsCreateContentRequest($t, $u, $m);
    }
}
