<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\PreviewFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Title
{
    public function adsPreviewTitleRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[1]['keyText'], 'adsPreviewTitle');
    }

    public function adsPreviewTitleStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsPreviewTitle', 'title', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->adsCreateKeyboard[1]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->title = $m->text;

                return $x;
            });
        });
        $this->adsPreview($t, $u, $m);
    }

    public function adsPreviewTitleEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[9]['keyText'], 'adsPreviewTitleEn');
    }

    public function adsPreviewTitleEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsPreviewTitleEn', 'title_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->adsCreateKeyboard[9]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->title_en = $m->text;

                return $x;
            });
            // $this->adsCreate($t, $u);
        });
        $this->adsPreview($t, $u, $m);
    }
}
