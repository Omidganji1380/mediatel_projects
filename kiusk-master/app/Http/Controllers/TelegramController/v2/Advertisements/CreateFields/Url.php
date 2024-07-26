<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Url
{
    public function advertisementsCreateUrlRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $advertisementCreateUrlText = __('messages.advertisements.create_link');
        $this->request($t, $u, $m, $advertisementCreateUrlText, 'advertisementsCreateUrl');
    }

    public function advertisementsCreateUrlStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store(
            $t,
            $u,
            $m,
            'advertisementsCreateUrl',
            'url',
            function ($t, $u, $m, $data) {
                return \Validator::make(
                    [$data => $m->text],
                    [
                        $data => 'required|url',
                    ]
                );
            },
            function ($t, $u, $m) {
                $this->updateUserExtra(function ($x) use ($m) {
                    $x->advertisementsCreate->link = $m->text;

                    return $x;
                });
            },
            null,
            'advertisementsCreateLastStep'
        );
        // $this->advertisementsCreateUrlEnRequest($t, $u, $m);
    }
}
