<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\EditFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Url
{

    public function advertisementsEditUrlRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $text = __('messages.advertisements.edit_link');
        $this->requestAdvertisementEdit($t, $u, $m, $text, 'advertisementsEditUrl');
    }

    public function advertisementsEditUrlStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'advertisementsEditUrl', 'Url', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => 'required|url',
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->advertisementsEdit->link = $m->text;

                return $x;
            });
            $this->advertisementsEdit($t, $u);
        });
    }
}
