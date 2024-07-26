<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\PreviewFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Content
{
    public function advertisementsPreviewContentRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $advertisementCreateContentText = __('messages.advertisements.create_content');
        $this->request($t, $u, $m, $advertisementCreateContentText, 'advertisementsPreviewContent');
    }

    public function advertisementsPreviewContentStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'advertisementsPreviewContent', 'content', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => 'required',
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->advertisementsCreate->content = $m->text;

                return $x;
            });
            // $this->advertisementsCreate($t, $u);
        });
        $this->advertisementsPreview($t, $u, $m);
    }

    public function advertisementsPreviewContentEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $advertisementCreateContentEnText = __('messages.advertisements.create_content_en');
        $this->request($t, $u, $m, $advertisementCreateContentEnText, 'advertisementsPreviewContentEn');
    }

    public function advertisementsPreviewContentEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'advertisementsPreviewContentEn', 'content_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => 'required',
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->advertisementsCreate->content_en = $m->text;

                return $x;
            });
            // $this->advertisementsCreate($t, $u);
        });
        $this->advertisementsPreview($t, $u, $m);
    }
}
