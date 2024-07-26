<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\v2\Advertisements\PreviewFields\Category;
use App\Http\Controllers\TelegramController\v2\Advertisements\PreviewFields\Content;
use App\Http\Controllers\TelegramController\v2\Advertisements\PreviewFields\Gallery;
use App\Models\Ad\Attribute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Preview
{
    use Content;
    use Gallery;
    use Category;
    use AcceptTheRules;

    public function advertisementsPreview(Api $t, Update $u, Message|Collection|EditedMessage|null $m = null)
    {
        auth()?->user()?->lang ? App::setLocale(Auth::user()->lang ?: config('app.locale')) : null;

        if (!auth()?->user()?->phone_verified_at) {
            $this->inlineRegisterRequierd($t, $u);

            return;
        }

        if (!isset(auth()->user()->extra->advertisementsAcceptTheRulesMessageId)) {
            $this->advertisementsAcceptTheRules($t, $u);

            return;
        };

        $this->updateUserExtra(function ($x) {
            if (!isset($x->advertisementsCreate)) {
                $x->advertisementsCreate = new stdClass();
            }

            return $x;
        });

        $text = st()->profileText;
        $text .= $this->flashMassage();
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            // 'reply_markup' => $this->advertisementsPreviewKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }
}
