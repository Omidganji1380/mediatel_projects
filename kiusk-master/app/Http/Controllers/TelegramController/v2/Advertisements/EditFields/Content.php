<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\EditFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Content
{

    public function advertisementsEditContentRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $text = __('messages.advertisements.edit_description');
        $this->requestAdvertisementEdit($t, $u, $m, $text, 'advertisementsEditContent');
    }

    public function advertisementsEditContentStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'advertisementsEditContent', 'content', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => 'required|string|min:3',
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->advertisementsEdit->description = $m->text;

                return $x;
            });
            $this->advertisementsEdit($t, $u);
        });
    }

    public function advertisementsEditContentEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestAdvertisementEdit($t, $u, $m, st()->adsEditKeyboard[3]['keyText'], 'advertisementsEditContentEn');
    }

    public function advertisementsEditContentEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'advertisementsEditContentEn', 'content_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => 'required|string|min:3',
                // $data => 'required|string|min:3|regex:/^(.*\n){2}.*$/s|max:10000|' . st()->adsEditKeyboard[3]['keyRule'],
            ], [
                'content_en.regex' => __('validation.content_min_lines'),
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->advertisementsEdit->description_en = $m->text;

                return $x;
            });
            $this->advertisementsEdit($t, $u);
        });
    }
}
