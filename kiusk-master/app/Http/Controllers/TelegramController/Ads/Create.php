<?php

namespace App\Http\Controllers\TelegramController\Ads;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\Ads\CreateFields\Attr;
use App\Http\Controllers\TelegramController\Ads\CreateFields\Category;
use App\Http\Controllers\TelegramController\Ads\CreateFields\City;
use App\Http\Controllers\TelegramController\Ads\CreateFields\Content;
use App\Http\Controllers\TelegramController\Ads\CreateFields\FeaturedAd;
use App\Http\Controllers\TelegramController\Ads\CreateFields\Gallery;
use App\Http\Controllers\TelegramController\Ads\CreateFields\Price;
use App\Http\Controllers\TelegramController\Ads\CreateFields\State;
use App\Http\Controllers\TelegramController\Ads\CreateFields\Title;
use App\Http\Controllers\TelegramController\Methods;
use App\Models\Ad\Ad;
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

trait Create
{
    use Title;
    use Price;
    use Content;
    use State;
    use City;
    use Gallery;
    use Category;
    use Attr;
    use FeaturedAd;
    use Methods;

    public function adsCreate(Api $t, Update $u)
    {
        //  $user = auth()->user();
        //  if ($user->telegram_last_message !== 'لطفا عکس پروفایل خود را ارسال کنید') {
        //   $user->update([
        //          'telegram_last_message' => null,
        //          'telegram_last_method' => null,
        //         ]);
        //  }
        auth()?->user()?->lang ? App::setLocale( Auth::user()->lang ?: config('app.locale') ) : null;

        if(!auth()?->user()?->phone_verified_at){
            $buttons = Keyboard::button([
                'text' => st()->createAdVerifyPhoneKeyboard[0]['keyName'],
                'callback_data' => 'register'
            ]);
            $buttons1 = Keyboard::button([
                'text' => st()->createAdVerifyPhoneKeyboard[1]['keyName'],
                'callback_data' => 'startBack'
            ]);
            $keyboard = Keyboard::make()
                ->inline()
                ->row($buttons)
                ->row($buttons1);
            return $t->editMessageText([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => st()->phoneVerificationRequiredError,
                'reply_markup' => $keyboard,
            ]);
        }

        if (! isset(auth()->user()->extra->adsAcceptTheRulesMessageId)) {
            $this->adsAcceptTheRules($t, $u);

            return;
        };
        $this->updateUserExtra(function ($x) {
            if (! isset($x->adsCreate)) {
                $x->adsCreate = new stdClass();
            }

            return $x;
        });
        $r = $t->editMessageText([
                                  'chat_id' => $u->getChat()->id,
                                  'message_id' => $this->getLastMessageId(),
                                  'text' => st()->adsCreateText . $this->flashMassage(),
                                  'reply_markup' => $this->adsCreateKeyboard(),
                                 ]);
    }

    public function adsCreateKeyboard(): Keyboard
    {
        /**
         * @var $newAd Ad
         * */
        $newAd = auth()->user()->extra->adsCreate;
        $b_1 = Keyboard::inlineButton([
                                       'text' => isset($newAd->category_id) ? \App\Models\Ad\Category::find($newAd->category_id)->locale_name : '❌',
                                       'callback_data' => 'adsCreateCategoryRequest',
                                      ]);
        $b1_1 = Keyboard::inlineButton([
                                        'text' => st()->adsCreateKeyboard[0]['keyName'],
                                        'callback_data' => 'adsCreateCategoryRequest',
                                       ]);
        $b = Keyboard::inlineButton([
                                     'text' => $newAd->title ?? '❌',
                                     'callback_data' => 'adsCreateTitleRequest',
                                    ]);
        $b1 = Keyboard::inlineButton([
                                      'text' => st()->adsCreateKeyboard[1]['keyName'],
                                      'callback_data' => 'adsCreateTitleRequest',
                                     ]);
        $b9_1 = Keyboard::inlineButton([
                                     'text' => $newAd->title_en ?? '❌',
                                     'callback_data' => 'adsCreateTitleEnRequest',
                                    ]);
        $b9_2 = Keyboard::inlineButton([
                                      'text' => st()->adsCreateKeyboard[9]['keyName'],
                                      'callback_data' => 'adsCreateTitleEnRequest',
                                     ]);
        $b_2 = Keyboard::inlineButton([
                                       /*
                                        * todo done for Setting
                                        * */
                                       'text' => isset($newAd->price) ? (string)Money::USD($newAd->price, true) : '❌',
                                       'callback_data' => 'adsCreatePriceRequest',
                                      ]);
        $b1_2 = Keyboard::inlineButton([
                                        'text' => st()->adsCreateKeyboard[2]['keyName'],
                                        'callback_data' => 'adsCreatePriceRequest',
                                       ]);
        $b2 = Keyboard::inlineButton([
                                      'text' => $newAd->content ?? '❌',
                                      'callback_data' => 'adsCreateContentRequest',
                                     ]);
        $b3 = Keyboard::inlineButton([
                                      'text' => st()->adsCreateKeyboard[3]['keyName'],
                                      'callback_data' => 'adsCreateContentRequest',
                                     ]);
        $b10_1 = Keyboard::inlineButton([
                                      'text' => $newAd->content_en ?? '❌',
                                      'callback_data' => 'adsCreateContentEnRequest',
                                     ]);
        $b10_2 = Keyboard::inlineButton([
                                      'text' => st()->adsCreateKeyboard[10]['keyName'],
                                      'callback_data' => 'adsCreateContentEnRequest',
                                     ]);
        // $b11_1 = Keyboard::inlineButton([
        //                               'text' => isset($newAd->is_featured) ? ($newAd->is_featured ? __('Yes') : __('No')) : '❌',
        //                               'callback_data' => 'adsCreateIsFeaturedRequest',
        //                              ]);
        // $b11_2 = Keyboard::inlineButton([
        //                               'text' => st()->adsCreateKeyboard[11]['keyName'],
        //                               'callback_data' => 'adsCreateIsFeaturedRequest',
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
                                      'callback_data' => 'adsCreateGalleryRequest',
                                     ]);
        $b5 = Keyboard::inlineButton([
                                      'text' => st()->adsCreateKeyboard[4]['keyName'],
                                      'callback_data' => 'adsCreateGalleryRequest',
                                     ]);
        $b6 = Keyboard::inlineButton([
                                      'text' => isset($newAd->city_id) ? \App\Models\Address\City::find($newAd->city_id)->name : '❌',
                                      'callback_data' => 'adsCreateCityRequest',
                                     ]);
        $b8 = Keyboard::inlineButton([
                                      'text' => st()->adsCreateKeyboard[5]['keyName'],
                                      'callback_data' => 'adsCreateCityRequest',
                                     ]);
        $b9 = Keyboard::inlineButton([
                                      'text' => isset($newAd->state_id) ? \App\Models\Address\State::find($newAd->state_id)->name : '❌',
                                      'callback_data' => 'adsCreateStateRequest',
                                     ]);
        $b10 = Keyboard::inlineButton([
                                       'text' => st()->adsCreateKeyboard[6]['keyName'],
                                       'callback_data' => 'adsCreateStateRequest',
                                      ]);
        $b7 = Keyboard::inlineButton([
                                      'text' => st()->adsCreateKeyboard[7]['keyName'],
                                      'callback_data' => 'startBack',
                                     ]);
        $b11 = Keyboard::inlineButton([
                                       'text' => st()->adsCreateKeyboard[8]['keyName'],
                                       'callback_data' => 'adsCreateSendAndStore',
                                      ]);
        $keyboard = Keyboard::make()
                            ->inline()
                            ->row($b_1, $b1_1)
                            ->row($b, $b1)
                            ->row($b9_1, $b9_2)
                            ->row($b_2, $b1_2)
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
                    $callback = 'adsCreateAttributeOptionRequest';
                } else {
                    $callback = 'adsCreateAttributeRequest';
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

    public function adsCreateSendAndStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $adcreate = auth()->user()->extra->adsCreate;
        $data = json_decode(json_encode($adcreate), true);
        $validation = \Validator::make($data, [
            'title' => 'required|' . st()->adsCreateKeyboard[1]['keyRule'],
            'title_en' => 'required|' . st()->adsCreateKeyboard[9]['keyRule'],
            'content' => 'required|' . st()->adsCreateKeyboard[3]['keyRule'],
            'content_en' => 'required|' . st()->adsCreateKeyboard[10]['keyRule'],
            'state_id' => 'required',
            'category_id' => 'required',
            'is_featured' => 'nullable',
        ]);
        if ($validation->fails()) {
            $this->errorMessage(implode('🚫' . PHP_EOL . '🚫', $validation->messages()
                ->all()));
            $this->adsCreate($t, $u);
        } else {
            $ad = Ad::create([
                              'title' => $adcreate->title,
                              'title_en' => $adcreate->title_en,
                              'slug' => \Str::slug($adcreate->title_en ?? $adcreate->title),
                              'content' => $adcreate->content,
                              'content_en' => $adcreate->content_en,
                              'is_featured' => $adcreate->is_featured ?? 0,
                              'price' => isset($adcreate->price) ? $adcreate->price : null,
                              'is_visible' => false,
                              'user_id' => auth()->id(),
                              'seo_title' => str_split($adcreate->title, 60)[0],
                              'seo_description' => str_split($adcreate->content, 160)[0],
                              'state_id' => $adcreate->state_id,
                              'city_id' => isset($adcreate->city_id) ? $adcreate->city_id : null,
                             ]);
            $ad->categories()
               ->attach($adcreate->category_id, ['is_main' => true]);
            /*
             *
             *
             * todo must be un comment
             *
             *  */ //dsdsdsdsd
            //   auth()
                // ->user()
                // ->getMedia('adsCreateGallery')
                // ->each(function ($item, $key) use ($ad) {
                //     if ($key === 0) {
                //     $item->move($ad, 'SpecialImage');
                //     }
                //     else {
                //     $item->move($ad, 'Gallery');
                //     }
                // });
            if (isset($adcreate->attributes) && count($adcreate->attributes)) {
                foreach ($adcreate->attributes as $attribute) {
                    $ad->attrs2()
                       ->create([
                                 'text' => isset($attribute->value) ? $attribute->value : null,
                                 'ad_attribute_id' => $attribute->id,
                                ]);
                }
            }
            $this->updateUserExtra(function ($x) use ($m) {
                unset($x->adsCreate);

                return $x;
            });

            if(!$this->adSubscriptionStatus($ad)){
                $button = Keyboard::inlineButton([
                    'text' => st()->adsEditKeyboard[10]['keyName'],
                    'url' => route('front.panel.user.plans.index', $ad->slug)
                ]);
                $button1 =  Keyboard::button([
                    'text' => st()->createAdVerifyPhoneKeyboard[1]['keyName'],
                    'callback_data' => 'startBack'
                ]);
                $keyboard = Keyboard::make()
                                    ->inline()
                                    ->row($button)
                                    ->row($button1);
                return $t->editMessageText([
                    'chat_id' => $u->getChat()->id,
                    'message_id' => $this->getLastMessageId(),
                    'text' => st()->userSubscriptionStatusError,
                    'reply_markup' => $keyboard,
                ]);
            }

            $message = st()->adsCreateSuccess;
            $this->successMessage($message);
            $this->startBack($t, $u);
        }
    }

    /**
     * Checl User Subscription status
     *
     * @param Ad $ad
     * @return boolean
     */
    public function adSubscriptionStatus(Ad $ad): bool
    {
        $user = Auth::user();
        $ad->is_featured ? $user->subscription()->increment('featured_usage') : $user->subscription()->increment('usage');
        return $user->subscriptionUsage($ad->is_featured);
    }
}
