<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\Attr;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\Category;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\City;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\Content;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\FeaturedAd;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\Gallery;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\Price;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\State;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\Title;
use App\Http\Controllers\TelegramController\v2\Advertisements\CreateFields\Url;
use App\Http\Controllers\TelegramController\v2\Methods;
use App\Jobs\CreateAdJob;
use App\Models\Ad\Ad;
use App\Models\Ad\Attribute;
use App\Models\TelegramAd;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Create
{
    use Content;
    use Gallery;
    use Category;
    use Url;
    use AcceptTheRules;
    use Methods;

    public function advertisementsCreate(Api $t, Update $u, Message|Collection|EditedMessage|null $m = null)
    {
        $this->reset();
        auth()?->user()?->lang ? App::setLocale(Auth::user()->lang ?: config('app.locale')) : null;

        if (!auth()?->user()?->phone_verified_at || !auth()?->user()?->email) {
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

        $this->advertisementsCreateCategoryRequest($t, $u, $m);
    }

    public function advertisementsCreateLastStep(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $this->setLanguage();
        $text = st()->adCreatePreviewText;
        // $text = __("Information has been successfully registered. Use the \"Send for confirmation and display\" button to save and final registration.");
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => $text,
            'reply_markup' => $this->returnToHomeKeyboard()
        ]);
        $r = $this->advertisementsCreatePreviewText($t, $u);

        // $r = $t->sendMessage([
        //     'chat_id' => $u->getChat()->id,
        //     'message_id' => $this->getLastMessageId(),
        //     'text' => $this->flashMassage(),
        //     'reply_markup' => $keyboard,
        //     'parse_mode' => 'HTML',
        //     // 'reply_markup' => $this->adsCreateKeyboard(),
        // ]);

        $this->updateLastRequestId($r->messageId);
    }

    public function advertisementsCreateSendAndStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $adcreate = auth()->user()->extra->advertisementsCreate;
        $data = json_decode(json_encode($adcreate), true);
        $validation = \Validator::make($data, [
            'description' => 'required|string',
            'description_en' => 'required|string',
            'link' => 'required|url',
            'ad_type' => 'required|in:' . implode(",", array_keys(\App\Models\TelegramAd::TYPES)),
        ]);
        if ($validation->fails()) {
            $this->errorMessage(implode('🚫' . PHP_EOL . '🚫', $validation->messages()
                ->all()));
            $this->advertisementsCreate($t, $u);
        } else {
            $ad = TelegramAd::create([
                'ad_type' => $adcreate->ad_type,
                'link' => $adcreate->link,
                'description' => $adcreate->description,
                'description_en' => $adcreate->description_en,
                'is_approved' => false,
                'user_id' => auth()->id(),
            ]);

            /*
             * todo must be un comment
             *
             *  */ //dsdsdsdsd
            if (auth()
                ->user()
                ->getMedia('advertisementsCreateGallery')->count()
            ) {
                auth()
                    ->user()
                    ->getMedia('advertisementsCreateGallery')
                    ->each(function ($item, $key) use ($ad) {
                        $item->move($ad, 'SpecialImage');
                    });

            } else {
                $ad->addMediaFromUrl('https://kiusk.ca/images/kiusk-placeholder.jpg')->toMediaCollection('SpecialImage');
            }

            if (auth()
                ->user()
                ->getMedia('advertisementsCreateGalleryEn')->count()
            ) {
                auth()
                    ->user()
                    ->getMedia('advertisementsCreateGalleryEn')
                    ->each(function ($item, $key) use ($ad) {
                        $item->move($ad, 'SpecialImageEn');
                    });

            } else {
                $ad->addMediaFromUrl('https://kiusk.ca/images/kiusk-placeholder.jpg')->toMediaCollection('SpecialImageEn');
            }
            $this->updateUserExtra(function ($x) use ($m) {
                unset($x->advertisementsCreate);

                return $x;
            });

            $message = __('messages.advertisements.create_success');
            $this->successMessage($message);
            $this->paymentAdvertisement($t, $u, $ad);
            // $lang = App::isLocale('fa') ? '' : 'en.';
            // $smsMessage = __('messages.telegram.createAdSmsText', [
            //     'title' => $ad->locale_title,
            //     'link' =>  route($lang . 'front.ad.show', $ad->slug)
            // ]);

            // CreateAdJob::dispatch(auth()->user(), $smsMessage);
        }
    }

    public function advertisementsCreatePreviewText(Api $t, Update $u)
    {
        $ad = auth()->user()?->extra?->advertisementsCreate ?? null;
        $image = auth()->user()->getFirstMedia('advertisementsCreateGallery');

        $linkButtonText = __('Display Ad');
        $link = '
<a href="' . $ad->link . '">'. $linkButtonText .'</a>';
        $caption = $ad->description . $link;

        if($image){
            $b11 = Keyboard::inlineButton([
                'text' => st()->adsCreateKeyboard[8]['keyName'],
                'callback_data' => 'advertisementsCreateSendAndStore',
            ]);
            $keyboard = Keyboard::make()
                ->inline()->row($b11);
            $path = str_replace('\\', '/', $image->getPath());
            $r = $t->sendPhoto([
                'chat_id' => $u->getChat()->id,
                'photo' => InputFile::create($path, auth()->user()->id),
                'caption' => $caption,
                'reply_markup' => $keyboard,
                'parse_mode' => 'HTML'
            ]);
            return $r;
        }
    }

    public function paymentAdvertisement($t, $u, $ad)
    {
        $b11 = Keyboard::inlineButton([
            'text' => __('Payment Link'),
            'url' => route('front.panel.user.plans.telegram-ads', ['telegramAd' => $ad->id, 'model_type' => 'telegramAd'])
        ]);
        $text = __("messages.advertisements.payment");
        $keyboard = Keyboard::make()
            ->inline()->row($b11);
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
    }

}
