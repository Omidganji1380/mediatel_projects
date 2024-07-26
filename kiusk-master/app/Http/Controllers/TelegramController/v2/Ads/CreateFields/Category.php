<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\CreateFields;

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
    public function adsCreateCategoryRequest(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage|null $m,
        $parenCategory = null
    ): void {
        auth()?->user()?->lang ? App::setLocale(Auth::user()->lang ?: config('app.locale')) : null;

        $category = \App\Models\Ad\Category::find($parenCategory);
        if($category){
            $policyType = $category?->type  . '_create';
            if(!auth()->user()->can($policyType)){
                $this->errorMessage(__('messages.permissions.create_ad_denied'));
                $this->accessLevelRequest($t, $u);
            }else{
                $text = st()->adsCreateKeyboard[0]['keyText'];
                $text .= $this->flashMassage();
                $this->deleteLastRequest($t, $u);
                $r = $t->sendMessage([
                    'chat_id' => $u->getChat()->id,
                    'message_id' => $this->getLastMessageId(),
                    'text' => $text,
                    'reply_markup' => $this->adsCreateCategoryRequestKeyboard($parenCategory),
                ]);
                $this->updateLastRequestId($r->messageId);
            }
        }else{
            $text = st()->adsCreateKeyboard[0]['keyText'];
            $text .= $this->flashMassage();
            $this->deleteLastRequest($t, $u);
            $r = $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => $text,
                'reply_markup' => $this->adsCreateCategoryRequestKeyboard($parenCategory),
            ]);
            $this->updateLastRequestId($r->messageId);
        }
    }

    public function sendCategoryLists(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage|null $m,
        $parenCategory = null
    ) : void
    {
        $text = st()->adsCreateKeyboard[0]['keyText'];
        $text .= $this->flashMassage();
        $this->deleteLastRequest($t, $u);
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsCreateCategoryRequestKeyboard($parenCategory),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsCreateCategoryStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $categoryId): void
    {
        $this->setLanguage();
        // $category = \App\Models\Ad\Category::find($categoryId);
        // $policyType = $category?->type  . '_create';
        // if(!auth()->user()->can($policyType)){
        //     $this->errorMessage(__('messages.permissions.create_ad_denied'));
        //     $this->startBack($t, $u);
        // }else{
            $this->updateUserExtra(function ($x) use ($m, $categoryId) {
                $category = \App\Models\Ad\Category::find($categoryId);
                if(!isset($x->adsCreate)){
                    $x->adsCreate = new stdClass();
                }
                $x->adsCreate->category_id = $categoryId;
                $x->adsCreate->type = $category?->type;
                $x->adsCreate->sale_type = $category?->sale_type;
                $x->adsCreate->attributes = $category?->attrs;
                return $x;
            });
            $this->adsCreateTitleRequest($t, $u, $m);
        // }

    }

    public function adsCreateCategoryRequestKeyboard($parenCategory): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\Ad\Category::whereParentId($parenCategory)
            ->withCount(['children' => function($query){
                $query->where('is_visible', true)
                ->where('show_in_telegram', true);
            }])
            ->where('is_visible', true)
            ->where('show_in_telegram', true)
            ->get()
            ->each(function ($item) use ($keyboard, $parenCategory) {
                $b = Keyboard::inlineButton([
                    'text' => $item->name_with_emoji,
                    // 'text' => $item->name_with_emoji  . ($item->children_count ? ' ◀' : ''),
                    'callback_data' => ($item->children_count ? 'adsCreateCategoryRequest' : 'adsCreateCategoryStore') . $item->id,
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
            'callback_data' => 'adsCreate',
        ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }
}
