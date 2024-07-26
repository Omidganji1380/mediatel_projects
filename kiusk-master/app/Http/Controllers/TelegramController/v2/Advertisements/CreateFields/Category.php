<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Category
{
    public function advertisementsCreateCategoryRequest(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage|null $m
    ): void {
        auth()?->user()?->lang ? App::setLocale(Auth::user()->lang ?: config('app.locale')) : null;

        $category = \App\Models\TelegramAd::TYPES;
        $text = __('messages.advertisements.select_category');
        $text .= $this->flashMassage();
        $this->deleteLastRequest($t, $u);
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->advertisementsCreateCategoryRequestKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function advertisementsCreateCategoryStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $type): void
    {
        $this->setLanguage();
        $this->updateUserExtra(function ($x) use ($m, $type) {
            if (!isset($x->advertisementsCreate)) {
                $x->advertisementsCreate = new stdClass();
            }
            $x->advertisementsCreate->ad_type = $type;
            return $x;
        });
        $this->advertisementsCreateGalleryRequest($t, $u, $m);
    }

    public function advertisementsCreateCategoryRequestKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        $categories = collect(\App\Models\TelegramAd::TYPES);
        $categories->each(function ($item, $key) use ($keyboard) {
            $b = Keyboard::inlineButton([
                'text' => __('messages.categories.types.' . $key),
                'callback_data' => 'advertisementsCreateCategoryStore' . $key,
            ]);
            $keyboard->row($b);
        });
        $b = Keyboard::inlineButton([
            'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
            'callback_data' => 'advertisementsCreate',
        ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
