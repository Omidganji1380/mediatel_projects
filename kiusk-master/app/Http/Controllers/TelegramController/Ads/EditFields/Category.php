<?php

namespace App\Http\Controllers\TelegramController\Ads\EditFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Category
{
    public function adsEditCategoryRequest(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        $parenCategory = null
    ): void
    {
        $text = st()->adsEditKeyboard[0]['keyText'];
        $r = $t->editMessageText([
                                  'chat_id' => $u->getChat()->id,
                                  'message_id' => $this->getLastMessageId(),
                                  'text' => $text,
                                  'reply_markup' => $this->adsEditCategoryRequestKeyboard($parenCategory),
                                 ]);
    }

    public function adsEditCategoryStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $categoryId): void
    {
        $this->updateUserExtra(function ($x) use ($m, $categoryId) {
            $x->adsEdit->category_id = $categoryId;
            $x->adsEdit->attributes = \App\Models\Ad\Category::find($categoryId)?->attrs;

            return $x;
        });
        $this->adsEdit($t, $u);
    }

    public function adsEditCategoryRequestKeyboard($parenCategory): Keyboard
    {
        $keyboard = Keyboard::make()
                            ->inline();
        \App\Models\Ad\Category::whereParentId($parenCategory)
                               ->withCount('children')
                               ->get()
                               ->each(function ($item) use ($keyboard, $parenCategory) {
                                   $b = Keyboard::inlineButton([
                                                                'text' => (auth()->user()?->isLangFa() ? $item->name : $item->name_en) . ($item->children_count ? '◀' : ''),
                                                                'callback_data' => ($item->children_count ? 'adsEditCategoryRequest' : 'adsEditCategoryStore') . $item->id,
                                                               ]);
                                   $keyboard->row($b);
                               });
        //  if ($parenCategory !==null) {
        //   $b = Keyboard::inlineButton([
//                                'text' => 'متفرقه',
//                                'callback_data' => 'adsEditCategoryStore' . $parenCategory
//                               ]);
        //   $keyboard = $keyboard->row($b);
        //  }
        $b = Keyboard::inlineButton([
                                     'text' => auth()->user()?->isLangFa() ? 'بازگشت' : 'Return',
                                     'callback_data' => 'adsEdit',
                                    ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
