<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\PreviewFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Content
{
    public function adsPreviewContentRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[3]['keyText'], 'adsPreviewContent');
    }

    public function adsPreviewContentStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsPreviewContent', 'content', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
             $data => st()->adsCreateKeyboard[3]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->content = $m->text;

                return $x;
            });
            // $this->adsCreate($t, $u);
        });
        $this->adsPreview($t, $u, $m);
    }

    public function adsPreviewContentEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[10]['keyText'], 'adsPreviewContentEn');
    }

    public function adsPreviewContentEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsPreviewContentEn', 'content_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
             $data => st()->adsCreateKeyboard[10]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->content_en = $m->text;

                return $x;
            });
            // $this->adsCreate($t, $u);
        });
        $this->adsPreview($t, $u, $m);
    }
}
