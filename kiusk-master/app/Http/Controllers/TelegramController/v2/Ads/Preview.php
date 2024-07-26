<?php

namespace App\Http\Controllers\TelegramController\v2\Ads;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\Attr;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\Category;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\City;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\Content;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\FeaturedAd;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\Gallery;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\Price;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\State;
use App\Http\Controllers\TelegramController\v2\Ads\PreviewFields\Title;
use App\Models\Ad\Ad;
use App\Models\Ad\Attribute;
use App\Models\User;
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
    use Title;
    use Price;
    use Content;
    use State;
    use City;
    use Gallery;
    use Category;
    use Attr;
    // use FeaturedAd;

    public function adsPreview(Api $t, Update $u, Message|Collection|EditedMessage|null $m = null)
    {
        auth()?->user()?->lang ? App::setLocale(Auth::user()->lang ?: config('app.locale')) : null;

        if (!auth()?->user()?->phone_verified_at) {
            $this->inlineRegisterRequierd($t, $u);

            return;
        }

        if (!isset(auth()->user()->extra->adsAcceptTheRulesMessageId)) {
            $this->adsAcceptTheRules($t, $u);

            return;
        };

        $this->updateUserExtra(function ($x) {
            if (!isset($x->adsCreate)) {
                $x->adsCreate = new stdClass();
            }

            return $x;
        });

        $text = st()->profileText;
        $text .= $this->flashMassage();
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->adsPreviewKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsPreviewKeyboard(): Keyboard
    {
        /**
         * @var $newAd Ad
         * */
        $newAd = auth()->user()->extra->adsCreate;
        $b_1 = Keyboard::inlineButton([
            'text' => isset($newAd->category_id) ? \App\Models\Ad\Category::find($newAd->category_id)->locale_name : '❌',
            'callback_data' => 'adsPreviewCategoryRequest',
        ]);
        $b1_1 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[0]['keyName'],
            'callback_data' => 'adsPreviewCategoryRequest',
        ]);
        $b = Keyboard::inlineButton([
            'text' => $newAd->title ?? '❌',
            'callback_data' => 'adsPreviewTitleRequest',
        ]);
        $b1 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[1]['keyName'],
            'callback_data' => 'adsPreviewTitleRequest',
        ]);
        $b9_1 = Keyboard::inlineButton([
            'text' => $newAd->title_en ?? '❌',
            'callback_data' => 'adsPreviewTitleEnRequest',
        ]);
        $b9_2 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[9]['keyName'],
            'callback_data' => 'adsPreviewTitleEnRequest',
        ]);
        $b_2 = Keyboard::inlineButton([
            /*
                                        * todo done for Setting
                                        * */
            'text' => isset($newAd->price) ? (string)Money::USD($newAd->price, true) : '❌',
            'callback_data' => 'adsPreviewPriceRequest',
        ]);
        $b1_2 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[2]['keyName'],
            'callback_data' => 'adsPreviewPriceRequest',
        ]);
        $b2 = Keyboard::inlineButton([
            'text' => $newAd->content ?? '❌',
            'callback_data' => 'adsPreviewContentRequest',
        ]);
        $b3 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[3]['keyName'],
            'callback_data' => 'adsPreviewContentRequest',
        ]);
        $b10_1 = Keyboard::inlineButton([
            'text' => $newAd->content_en ?? '❌',
            'callback_data' => 'adsPreviewContentEnRequest',
        ]);
        $b10_2 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[10]['keyName'],
            'callback_data' => 'adsPreviewContentEnRequest',
        ]);
        // $b11_1 = Keyboard::inlineButton([
        //                               'text' => isset($newAd->is_featured) ? ($newAd->is_featured ? __('Yes') : __('No')) : '❌',
        //                               'callback_data' => 'adsPreviewIsFeaturedRequest',
        //                              ]);
        // $b11_2 = Keyboard::inlineButton([
        //                               'text' => st()->adsCreateKeyboard[11]['keyName'],
        //                               'callback_data' => 'adsPreviewIsFeaturedRequest',
        //                              ]);
        $count = auth()
            ->user()
            ->getMedia('adsCreateGallery')
            ->count();
        if (session('numberGalleryAddOne')) {
            $count++;
            session()->forget('numberGalleryAddOne');
        }
        $b4 = Keyboard::inlineButton([
            'text' => $count ? (auth()?->user()?->isLangFa() ? "تعداد عکس ها: " : "Pictures count: ") . $count . '✅' : '❌',
            'callback_data' => 'adsPreviewGalleryRequest',
        ]);
        $b5 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[4]['keyName'],
            'callback_data' => 'adsPreviewGalleryRequest',
        ]);
        $b6 = Keyboard::inlineButton([
            'text' => isset($newAd->city_id) ? \App\Models\Address\City::find($newAd->city_id)->name : '❌',
            'callback_data' => 'adsPreviewCityRequest',
        ]);
        $b8 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[5]['keyName'],
            'callback_data' => 'adsPreviewCityRequest',
        ]);
        $b9 = Keyboard::inlineButton([
            'text' => isset($newAd->state_id) ? \App\Models\Address\State::find($newAd->state_id)->name : '❌',
            'callback_data' => 'adsPreviewStateRequest',
        ]);
        $b10 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[6]['keyName'],
            'callback_data' => 'adsPreviewStateRequest',
        ]);
        $b7 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[7]['keyName'],
            'callback_data' => 'startBack',
        ]);
        $b11 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[8]['keyName'],
            'callback_data' => 'adsPreviewSendAndStore',
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($b_1, $b1_1)
            ->row($b, $b1)
            ->row($b9_1, $b9_2)
            // ->row($b_2, $b1_2)
            ->row($b2, $b3)
            ->row($b10_1, $b10_2)
            // ->row($b11_1, $b11_2)
            ->row($b4, $b5)
            ->row($b6, $b8, $b9, $b10);
        if (isset($newAd->attributes)) {
            foreach ($newAd->attributes as $attr) {
                /**
                 * @var Attribute $attr
                 */
                if ($attr?->options && count($attr->options)) {
                    $callback = 'adsPreviewAttributeOptionRequest';
                } else {
                    $callback = 'adsPreviewAttributeRequest';
                }
                $b200 = Keyboard::inlineButton([
                    'text' => $attr->value ?? '❌',
                    'callback_data' => $callback . $attr->id,
                ]);
                $b201 = Keyboard::inlineButton([
                    'text' => $attr->name,
                    'callback_data' => $callback . $attr->id,
                ]);
                $keyboard->row($b200, $b201);
            }
        }
        $keyboard->row($b11);
        $keyboard->row($b7);

        return $keyboard;
    }

    // public function adsCreateSendAndStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    // {
    //     $adcreate = auth()->user()->extra->adsCreate;
    //     $data = json_decode(json_encode($adcreate), true);
    //     $validation = \Validator::make($data, [
    //         'title' => 'required|' . st()->adsCreateKeyboard[1]['keyRule'],
    //         'title_en' => 'required|' . st()->adsCreateKeyboard[9]['keyRule'],
    //         'content' => 'required|' . st()->adsCreateKeyboard[3]['keyRule'],
    //         'content_en' => 'required|' . st()->adsCreateKeyboard[10]['keyRule'],
    //         'state_id' => 'required',
    //         'category_id' => 'required',
    //         'is_featured' => 'nullable',
    //     ]);
    //     if ($validation->fails()) {
    //         $this->errorMessage(implode('🚫' . PHP_EOL . '🚫', $validation->messages()
    //             ->all()));
    //         $this->adsCreate($t, $u);
    //     } else {
    //         $ad = Ad::create([
    //             'title' => $adcreate->title,
    //             'title_en' => $adcreate->title_en,
    //             'slug' => \Str::slug($adcreate->title_en ?? $adcreate->title),
    //             'content' => $adcreate->content,
    //             'content_en' => $adcreate->content_en,
    //             'is_featured' => $adcreate->is_featured ?? 0,
    //             'price' => isset($adcreate->price) ? $adcreate->price : null,
    //             'is_visible' => false,
    //             'user_id' => auth()->id(),
    //             'seo_title' => str_split($adcreate->title, 60)[0],
    //             'seo_description' => str_split($adcreate->content, 160)[0],
    //             'state_id' => $adcreate->state_id,
    //             'city_id' => isset($adcreate->city_id) ? $adcreate->city_id : null,
    //         ]);
    //         $ad->categories()
    //             ->attach($adcreate->category_id, ['is_main' => true]);
    //         /*
    //          *
    //          *
    //          * todo must be un comment
    //          *
    //          *  */ //dsdsdsdsd
    //         //   auth()
    //         // ->user()
    //         // ->getMedia('adsCreateGallery')
    //         // ->each(function ($item, $key) use ($ad) {
    //         //     if ($key === 0) {
    //         //     $item->move($ad, 'SpecialImage');
    //         //     }
    //         //     else {
    //         //     $item->move($ad, 'Gallery');
    //         //     }
    //         // });
    //         if (isset($adcreate->attributes) && count($adcreate->attributes)) {
    //             foreach ($adcreate->attributes as $attribute) {
    //                 $ad->attrs2()
    //                     ->create([
    //                         'text' => isset($attribute->value) ? $attribute->value : null,
    //                         'ad_attribute_id' => $attribute->id,
    //                     ]);
    //             }
    //         }
    //         $this->updateUserExtra(function ($x) use ($m) {
    //             unset($x->adsCreate);

    //             return $x;
    //         });

    //         if (!$this->adSubscriptionStatus($ad)) {
    //             $button = Keyboard::inlineButton([
    //                 'text' => st()->adsEditKeyboard[10]['keyName'],
    //                 'url' => route('front.panel.user.plans.index', $ad->slug)
    //             ]);
    //             $button1 =  Keyboard::button([
    //                 'text' => st()->createAdVerifyPhoneKeyboard[1]['keyName'],
    //                 'callback_data' => 'startBack'
    //             ]);
    //             $keyboard = Keyboard::make()
    //                 ->inline()
    //                 ->row($button)
    //                 ->row($button1);
    //             return $t->editMessageText([
    //                 'chat_id' => $u->getChat()->id,
    //                 'message_id' => $this->getLastMessageId(),
    //                 'text' => st()->userSubscriptionStatusError,
    //                 'reply_markup' => $keyboard,
    //             ]);
    //         }

    //         $message = st()->adsCreateSuccess;
    //         $this->successMessage($message);
    //         $this->startRemoveKeyboard($t, $u);
    //     }
    // }
}
