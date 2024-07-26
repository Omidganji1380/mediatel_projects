<?php

namespace App\Http\Controllers\TelegramController\v2\Ads;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\Attr;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\Category;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\City;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\Content;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\FeaturedAd;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\Gallery;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\Price;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\State;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\Title;
use App\Http\Controllers\TelegramController\v2\Methods;
use App\Jobs\CreateAdJob;
use App\Models\Ad\Ad;
use App\Models\Ad\Attribute;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
    use CreateRealEstate;
    use Methods;

    /**
     * Displays
     *
     * @param Api $t
     * @param Update $u
     * @param Message|Collection|EditedMessage|null|null $m
     * @return void
     */
    public function adsCreate(Api $t, Update $u, Message|Collection|EditedMessage|null $m = null)
    {
        //  $user = auth()->user();
        //  if ($user->telegram_last_message !== 'لطفا عکس پروفایل خود را ارسال کنید') {
        //   $user->update([
        //          'telegram_last_message' => null,
        //          'telegram_last_method' => null,
        //         ]);
        //  }
        $this->reset();
        auth()?->user()?->lang ? App::setLocale(Auth::user()->lang ?: config('app.locale')) : null;

        if (!auth()?->user()?->phone_verified_at || !auth()?->user()?->email) {
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

        auth()->user()->getMedia('adsCreateGallery')->each(function ($item, $key) {
            $item->delete();
        });

        $this->adsCreateCategoryRequest($t, $u, $m);
    }

    public function nextButton(Api $t, Update $u, Message|Collection|EditedMessage $m, $keyBoradName, $name)
    {
        $this->request($t, $u, $m, $keyBoradName, $name);
    }

    public function lastStep(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $this->setLanguage();
        $text = st()->adCreatePreviewText;
        // $text = __("Information has been successfully registered. Use the \"Send for confirmation and display\" button to save and final registration.");
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => $text,
            'reply_markup' => $this->returnToHomeKeyboard()
        ]);
        $text = $this->adsCreatePreviewText();
        $b11 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[8]['keyName'],
            'callback_data' => 'adsCreateSendAndStore',
        ]);
        $keyboard = Keyboard::make()
            ->inline()->row($b11);
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text . $this->flashMassage(),
            'reply_markup' => $keyboard,
            'parse_mode' => 'HTML',
            // 'reply_markup' => $this->adsCreateKeyboard(),
        ]);

        $this->updateLastRequestId($r->messageId);
    }

    public function finalStepKeyboard()
    {
        return Keyboard::make()->row(Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[8]['keyName'] . ' 📥',
            'callback_data' => 'adsCreateSendAndStore'
        ]));
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
        // if (session('numberGalleryAddOne')) {
        //     $count++;
        //     session()->forget('numberGalleryAddOne');
        // }
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

    /**
     * Validate and stores the saved data in the extra feilds of the user as stdclass
     * move the media from user gallery to the ads gallery, and if its not set uses the image placeholder
     *
     *
     * @param Api $t
     * @param Update $u
     * @param Message|Collection|EditedMessage $m
     * @return void
     */
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
            try {
                DB::beginTransaction();
                $content = mb_convert_encoding($adcreate->content, 'UTF-8', 'UTF-8');
                $ad = Ad::create([
                    'title' => $adcreate->title,
                    'title_en' => $adcreate->title_en,
                    'slug' => $this->createUniqueSlug(Ad::class, $adcreate->title_en),
                    // 'slug' => \Str::slug($adcreate->title_en ?? $adcreate->title),
                    'content' => $content,
                    'content_en' => $adcreate->content_en,
                    'is_featured' => $adcreate->is_featured ?? 0,
                    'price' => isset($adcreate->price) ? $adcreate->price : null,
                    'is_visible' => false,
                    'user_id' => auth()->id(),
                    'seo_title' => str_split($adcreate->title, 60)[0],
                    // 'seo_description' => str_split($content, 160)[0],
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
                if (auth()
                    ->user()
                    ->getMedia('adsCreateGallery')->count()
                ) {
                    auth()
                        ->user()
                        ->getMedia('adsCreateGallery')
                        ->each(function ($item, $key) use ($ad) {
                            if ($key === 0) {
                                $item->move($ad, 'SpecialImage');
                            } else {
                                $item->move($ad, 'Gallery');
                            }
                        });
                } else {
                    $ad->addMediaFromUrl('https://kiusk.ca/images/kiusk-placeholder.jpg')->toMediaCollection('SpecialImage');
                }

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
                $message = st()->adsCreateSuccess;
                $lang = App::isLocale('fa') ? '' : 'en.';
                $smsMessage = __('messages.telegram.createAdSmsText', [
                    'title' => $ad->locale_title,
                    'link' =>  route($lang . 'front.ad.show', $ad->slug)
                ]);
                DB::commit();
                $this->successMessage($message);
                $this->startRemoveKeyboard($t, $u);
                CreateAdJob::dispatch(auth()->user(), $smsMessage);
                // app(\App\Services\Sms\SmsService::class)->sendMessage(auth()->user()->phone, $smsMessage);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $this->errorMessage('🚫' . __("messages.unknown_error_message") . '🚫');
                auth()->user()->getMedia('adsCreateGallery')->each(function ($item, $key) {
                    if (!Storage::exists($item->getPath())) {
                        $item->delete();
                    }
                });
                $this->updateUserExtra(function ($x) use ($m) {
                    unset($x->adsCreate);

                    return $x;
                });
                $this->startRemoveKeyboard($t, $u);
            }
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

    public function registerRequierd(Api $t, Update $u, Message|Collection|EditedMessage|null $m = null)
    {
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
        return $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => st()->phoneVerificationRequiredError,
            'reply_markup' => $keyboard,
        ]);
    }
    public function inlineRegisterRequierd(Api $t, Update $u, Message|Collection|EditedMessage|null $m = null): void
    {
        $buttons = Keyboard::button([
            'text' => st()->createAdVerifyPhoneKeyboard[0]['keyName'],
            'callback_data' => 'register'
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($buttons);
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => st()->phoneVerificationRequiredError,
            'reply_markup' => $keyboard,
        ]);
    }

    public function adsCreatePreviewText(): string
    {
        $text = "";
        $adsCreate = auth()->user()?->extra?->adsCreate ?? null;
        if ($adsCreate) {
            $count = auth()
                ->user()
                ->getMedia('adsCreateGallery')
                ->count();
            $text = __('messages.telegram.adsCreatePreview', [
                'category' => isset($adsCreate->category_id) ? \App\Models\Ad\Category::find($adsCreate->category_id)->locale_name : '❌',
                'title' => $adsCreate->title,
                'title_en' => $adsCreate->title_en,
                'content' => $adsCreate->content,
                'content_en' => $adsCreate->content_en,
                'state' => isset($adsCreate->state_id) ? \App\Models\Address\State::find($adsCreate->state_id)->name : '❌',
                'city' => isset($adsCreate->city_id) ? \App\Models\Address\City::find($adsCreate->city_id)->name : '❌',
                'image' =>  $count ? (auth()?->user()?->isLangFa() ? "تعداد عکس ها: " : "Pictures count: ") . $count . '✅' : '❌'
            ]);
        }
        return $text;
    }

    public function accessLevelRequest(Api $t, Update $u) : void
    {
        $this->setLanguage();
        $text = $this->flashMassage();
        $upgradeTextButton =  __('Upgrade Level') . ' - (' . __('current') . ':' .  __('messages.roles.' . auth()->user()->getRoleNames()->first()) . ')';
        $inlineButtonUpgradeLevel = Keyboard::inlineButton([
            'text' => $upgradeTextButton,
            'callback_data' => 'profileUpgradeLevelRequest',
        ]);
        $back = Keyboard::inlineButton([
            'text' => __('Return To Main Menu'),
            'callback_data' => 'startBack',
        ]);

        $keyboard = Keyboard::make()
            ->inline()
            ->row($inlineButtonUpgradeLevel)
            ->row($back);

        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
    }
}
