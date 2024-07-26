<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\PreviewFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Category
{
    public function adsPreviewCategoryRequest(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        $parenCategory = null
    ): void {
        $text = st()->adsCreateKeyboard[0]['keyText'];
        $this->deleteLastRequest($t, $u);
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsPreviewCategoryRequestKeyboard($parenCategory),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsPreviewCategoryStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $categoryId): void
    {
        $this->updateUserExtra(function ($x) use ($m, $categoryId) {
            $x->adsCreate->category_id = $categoryId;
            $x->adsCreate->attributes = \App\Models\Ad\Category::find($categoryId)?->attrs;

            return $x;
        });
        $this->adsPreview($t, $u);
    }

    public function adsPreviewCategoryRequestKeyboard($parenCategory): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Ad\Category::whereParentId($parenCategory)
            ->withCount('children')
            ->get()
            ->each(function ($item) use ($keyboard, $parenCategory) {
                $b = Keyboard::inlineButton([
                    'text' => (auth()->user()->lang == 'fa' ? $item->name : $item->name_en)  . ($item->children_count ? '◀' : ''),
                    'callback_data' => ($item->children_count ? 'adsPreviewCategoryRequest' : 'adsPreviewCategoryStore') . $item->id,
                ]);
                $keyboard->row($b);
            });
        //  if ($parenCategory !==null) {
        //   $b = Keyboard::inlineButton([
        //                        'text' => 'متفرقه',
        //                        'callback_data' => 'adsCreateCategoryStore' . $parenCategory
        //                       ]);
        //   $keyboard = $keyboard->row($b);
        //  }
        $b = Keyboard::inlineButton([
            'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
            'callback_data' => 'adsPreview',
        ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
