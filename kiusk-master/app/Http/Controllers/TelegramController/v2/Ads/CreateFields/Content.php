<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields;

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
                $data => 'required|string|min:20|max:10000|' . st()->adsCreateKeyboard[3]['keyRule'],
                // $data => 'required|string|min:3|regex:/^(.*\n){2}.*$/s|max:10000|' . st()->adsCreateKeyboard[3]['keyRule'],
            ],[
                // 'content.regex' => __('validation.content_min_lines'),
            ]
        );
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->content = $m->text;

                return $x;
            });
            // $this->adsCreate($t, $u);
        },
        null,
        'adsCreateContentEnRequest'
        );
        // $this->adsCreateContentEnRequest($t, $u, $m);
    }

    public function adsCreateContentEnRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->request($t, $u, $m, st()->adsCreateKeyboard[10]['keyText'], 'adsCreateContentEn');
    }

    public function adsCreateContentEnStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'adsCreateContentEn', 'content_en', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => 'required|string|min:20|max:10000|' . st()->adsCreateKeyboard[10]['keyRule'],
                // $data => 'required|string|min:3|regex:/^(.*\n){2}.*$/s|max:10000|' . st()->adsCreateKeyboard[10]['keyRule'],
            ],[
                // 'content_en.regex' => __('validation.content_min_lines'),
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                $x->adsCreate->content_en = $m->text;

                return $x;
            });
            // $this->adsCreate($t, $u);
        },
        null,
        'adsCreateStateRequest'
        );
        // $this->adsCreateStateRequest($t, $u, $m);
    }
}
