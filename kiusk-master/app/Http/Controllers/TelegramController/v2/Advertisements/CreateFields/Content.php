<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Content
{
    public function advertisementsCreateContentRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $advertisementCreateContentText = __('messages.advertisements.create_content');
        $this->request($t, $u, $m, $advertisementCreateContentText, 'advertisementsCreateContent');
    }

    public function advertisementsCreateContentStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store(
            $t,
            $u,
            $m,
            'advertisementsCreateContent',
            'content',
            function ($t, $u, $m, $data) {
                return \Validator::make(
                    [$data => $m->text],
                    [
                        $data => 'required|string|min:3',
                    ]
                );
            },
            function ($t, $u, $m) {
                $this->updateUserExtra(function ($x) use ($m) {
                    $x->advertisementsCreate->description = $m->text;

                    return $x;
                });
            },
            null,
            'advertisementsCreateContentEnRequest'
        );
        // $this->advertisementsCreateContentEnRequest($t, $u, $m);
    }

    public function advertisementsCreateContentEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $advertisementCreateContentEnText = __('messages.advertisements.create_content_en');
        $this->request($t, $u, $m, $advertisementCreateContentEnText, 'advertisementsCreateContentEn');
    }

    public function advertisementsCreateContentEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store(
            $t,
            $u,
            $m,
            'advertisementsCreateContentEn',
            'content_en',
            function ($t, $u, $m, $data) {
                return \Validator::make([$data => $m->text], [
                    $data => 'required|string',
                ]);
            },
            function ($t, $u, $m) {
                $this->updateUserExtra(function ($x) use ($m) {
                    $x->advertisementsCreate->description_en = $m->text;

                    return $x;
                });
                // $this->advertisementsCreate($t, $u);
            },
            null,
            'advertisementsCreateUrlRequest'
        );
        // $this->advertisementsCreateStateRequest($t, $u, $m);
    }
}
