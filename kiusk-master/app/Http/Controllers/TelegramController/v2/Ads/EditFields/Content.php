<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\EditFields;

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
            //  $data => 'required|string|min:3|regex:/^(.*\n){2}.*$/s|max:10000|' . st()->adsEditKeyboard[3]['keyRule'],
             $data => 'required|string|min:20|max:10000|' . st()->adsEditKeyboard[3]['keyRule'],
            ],[
                // 'content.regex' => __('validation.content_min_lines'),
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
             $data => 'required|string|min:20|regex:/^(.*\n){2}.*$/s|max:10000|' . st()->adsEditKeyboard[3]['keyRule'],
            ],[
                'content_en.regex' => __('validation.content_min_lines'),
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
