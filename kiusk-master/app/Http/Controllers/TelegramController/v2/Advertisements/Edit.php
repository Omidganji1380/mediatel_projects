<?php

namespace App\Http\Controllers\TelegramController\v2\Advertisements;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\Attr;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\Category;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\City;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\Content;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\FeaturedAd;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\Gallery;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\Price;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\State;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\Title;
use App\Http\Controllers\TelegramController\v2\Advertisements\EditFields\Url;
use App\Http\Controllers\TelegramController\v2\Methods;
use App\Models\Ad\Ad;
use App\Models\Ad\Attribute;
use App\Models\TelegramAd;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Edit
{
    use Content;
    use Gallery;
    use Category;
    use AcceptTheRules;
    use Url;
    use Methods;

    public $type;
    public $sale_type;

    public function advertisementsEdit(Api $t, Update $u, $id = null): void
    {
        $user = auth()->user();
        if (!isset(auth()->user()->extra->advertisementsAcceptTheRulesMessageId)) {
            $this->advertisementsAcceptTheRules($t, $u);

            return;
        };
        // if($id && is_int($id)){
            $this->updateUserExtra(function ($x) use ($id) {
                if (!isset($x->advertisementsEdit)) {
                    $x->advertisementsEdit = new stdClass();
                }
                if ($id) {
                    $ad = TelegramAd::where('user_id', auth()->id())
                        ->where('id' , (int)$id)
                        ->first();

                    $x->advertisementsEdit = $ad;
                    $x->advertisementsEdit->ad_type = $this->type = $ad->ad_type;

                    $user = auth()->user();
                    $user->getMedia('advertisementsEditGallery')
                        ->each(function ($item) {
                            $item->delete();
                        });
                    $medias = Media::whereModelId($id)
                        ->whereModelType('telegramAd')
                        ->whereIn('collection_name', [
                            'SpecialImage',
                        ])
                        ->get();
                    $medias->each(function ($item) use ($user) {
                        $item->copy($user, 'advertisementsEditGallery');
                    });
                    $user->getMedia('advertisementsEditGalleryEn')
                        ->each(function ($item) {
                            $item->delete();
                        });
                    $medias = Media::whereModelId($id)
                        ->whereModelType('telegramAd')
                        ->whereIn('collection_name', [
                            'SpecialImageEn',
                        ])
                        ->get();
                    $medias->each(function ($item) use ($user) {
                        $item->copy($user, 'advertisementsEditGalleryEn');
                    });
                }

                return $x;
            });
            $r = $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => st()->adsEditText . $this->flashMassage(),
                'reply_markup' => $this->advertisementsEditKeyboard(),
            ]);
            $this->updateLastRequestId($r->messageId);
        // }else{
        //     $text = $this->flashMassage() ?: __('messages.advertisements.not_found');
        //     $r = $t->sendMessage([
        //         'chat_id' => $u->getChat()->id,
        //         'message_id' => $this->getLastMessageId(),
        //         'text' =>  $text,
        //         'reply_markup' => $this->returnToHomeKeyboard(),
        //     ]);
        // }

    }

    public function advertisementsEditKeyboard(): Keyboard
    {
        /**
         * @var $newAd Ad
         * */
        $user = auth()->user();
        $newAd = $user->extra->advertisementsEdit;

        $b_1 = Keyboard::inlineButton([
            'text' => __('messages.categories.types.' . $newAd->ad_type),
            'callback_data' => 'advertisementsEditCategoryRequest',
        ]);
        $b1_1 = Keyboard::inlineButton([
            'text' => __('Category'),
            'callback_data' => 'advertisementsEditCategoryRequest',
        ]);
        $b = Keyboard::inlineButton([
            'text' => $newAd->description ?? '❌',
            'callback_data' => 'advertisementsEditContentRequest',
        ]);
        $b1 = Keyboard::inlineButton([
            'text' => __('Description'),
            'callback_data' => 'advertisementsEditContentRequest',
        ]);
        $b2_1 = Keyboard::inlineButton([
            'text' => $newAd->link ?? '❌',
            'callback_data' => 'advertisementsEditUrlRequest',
        ]);
        $b2_2 = Keyboard::inlineButton([
            'text' => __('Advertiesment Link'),
            'callback_data' => 'advertisementsEditUrlRequest',
        ]);
        $b2 = Keyboard::inlineButton([
            'text' => $newAd->description_en ?? '❌',
            'callback_data' => 'advertisementsEditContentEnRequest',
        ]);
        $b3 = Keyboard::inlineButton([
            'text' => __("English Description"),
            'callback_data' => 'advertisementsEditContentEnRequest',
        ]);

        $count = $user->getMedia('advertisementsEditGallery')->count();

        $b4_1 = Keyboard::inlineButton([
            'text' => $count ? (auth()?->user()?->isLangFa() ? "تصویر فارسی: " : "Persian image: ") . '✅' : '❌',
            'callback_data' => 'advertisementsEditGalleryRequest',
        ]);
        $b4_2 = Keyboard::inlineButton([
            'text' => __("Persian Image"),
            'callback_data' => 'advertisementsEditGalleryRequest',
        ]);
        $count = $user->getMedia('advertisementsEditGalleryEn')->count();

        if (session('numberGalleryEnAddOne')) {
            $count++;
            session()->forget('numberGalleryEnAddOne');
        }
        $b5_1 = Keyboard::inlineButton([
            'text' => $count ? (auth()?->user()?->isLangFa() ? "تصویر انگلیسی: " : "English Image: ") . '✅' : '❌',
            'callback_data' => 'advertisementsEditGalleryEnRequest',
        ]);
        $b5_2 = Keyboard::inlineButton([
            'text' => __("English Image"),
            'callback_data' => 'advertisementsEditGalleryEnRequest',
        ]);

        $b10 = Keyboard::inlineButton([
            'text' => __("Return"),
            'callback_data' => 'advertisementsListBackToIt',
        ]);
        $b11 = Keyboard::inlineButton([
            'text' => __("messages.advertisements.confirm_edit"),
            'callback_data' => 'advertisementsEditSendAndStore',
        ]);
        $b12 = Keyboard::inlineButton([
            'text' => __("messages.advertisements.delete"),
            'callback_data' => 'advertisementsEditDeleteConfirm' . $newAd->id,
        ]);
        $b13 = Keyboard::inlineButton([
            'text' => __('Payment Link'),
            'url' => route('front.panel.user.plans.telegram-ads', ['telegramAd' => $newAd->id, 'model_type' => 'telegramAd'])
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($b_1, $b1_1)
            ->row($b, $b1)
            ->row($b2, $b3)
            ->row($b4_1, $b4_2)
            ->row($b5_1, $b5_2)
            ->row($b2_1, $b2_2);

        $keyboard->row($b11);
        $keyboard->row($b12);
        $keyboard->row($b13);
        $keyboard->row($b10);
        // $keyboard->row($b7);

        return $keyboard;
    }

    public function advertisementsEditSendAndStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $adedit = auth()->user()->extra->advertisementsEdit;
        $data = json_decode(json_encode($adedit), true);
        $validation = \Validator::make($data, [
            'description' => 'required|string',
            'description_en' => 'required|string',
            'ad_type' => 'required|in:' . implode(",", array_keys(\App\Models\TelegramAd::TYPES)),
            'link' => 'required|url',
        ]);
        if ($validation->fails()) {
            $this->errorMessage(implode('🚫' . PHP_EOL . '🚫', $validation->messages()
                ->all()));
            $this->advertisementsEdit($t, $u);
        } else {
            $ad = TelegramAd::whereId($adedit->id)
                ->whereUserId(auth()->id())
                ->first();
            $ad->update([
                'ad_type' => $adedit->ad_type,
                'description' => $adedit->description,
                'description_en' => $adedit->description_en,
                'is_approved' => false,
                'link' => $adedit->link,
            ]);
            /*
             *
             *
             * todo must be un comment
             *
             *  */ //dsdsdsdsd
            if (auth()
                ->user()
                ->getMedia('advertisementsEditGallery')->count()
            ) {
                auth()
                    ->user()
                    ->getMedia('advertisementsEditGallery')
                    ->each(function ($item, $key) use ($ad) {
                        if ($key === 0) {
                            $item->move($ad, 'SpecialImage');
                        } else {
                            $item->move($ad, 'Gallery');
                        }
                    });
            }else{
                $ad->addMediaFromUrl('https://via.placeholder.com/150')->toMediaCollection('SpecialImage');
            }
            if (auth()
                ->user()
                ->getMedia('advertisementsEditGalleryEn')->count()
            ) {
                auth()
                    ->user()
                    ->getMedia('advertisementsEditGalleryEn')
                    ->each(function ($item, $key) use ($ad) {
                        if ($key === 0) {
                            $item->move($ad, 'SpecialImageEn');
                        } else {
                            $item->move($ad, 'Gallery');
                        }
                    });
            }else{
                $ad->addMediaFromUrl('https://via.placeholder.com/150')->toMediaCollection('SpecialImageEn');
            }

            $ad->setStatus('pending_approval');

            $this->updateUserExtra(function ($x) use ($m) {
                unset($x->advertisementsEdit);

                return $x;
            });

            $lang = App::isLocale('fa') ? '' : 'en.';
            // $smsMessage = __('messages.telegram.editAdSmsText', [
            //     'title' => $ad->locale_title,
            //     'link' =>  route($lang . 'front.ad.show', $ad->slug)
            // ]);
            // app(\App\Services\Sms\SmsService::class)->sendMessage(auth()->user()->phone, $smsMessage);
            $this->successMessage(st()->adsEditSuccess);
            $this->advertisementsListBackToIt($t, $u, $m);
        }
    }

    public function advertisementsEditDeleteConfirm(Api $t, Update $u, Message|Collection|EditedMessage $m, $id)
    {
        // dump($id,'advertisementsEditDeleteConfirm');
        $b11 = Keyboard::inlineButton([
            'text' => '🚫🚫بله مطمئن هستم🚫🚫',
            'callback_data' => 'advertisementsEditDelete' . $id,
        ]);
        $b12 = Keyboard::inlineButton([
            'text' => 'خیر',
            'callback_data' => 'advertisementsEdit' . $id,
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($b11)
            ->row($b12);
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => st()->advertisementsEditKeyboard[9]['keyText'],
            'reply_markup' => $keyboard,
        ]);
    }

    public function advertisementsEditDelete(Api $t, Update $u, Message|Collection|EditedMessage $m, $id)
    {
        // dump($id,'advertisementsEditDelete');
        $lang = auth()?->user()?->isLangFa();
        $QB = TelegramAd::whereUserId(auth()->id())
            ->whereId($id);
        $ad = $QB->first();
        // dump($QB->explain());
        if ($ad) {
            $ad->delete();
            $this->updateUserExtra(function ($x) use ($m) {
                unset($x->advertisementsEdit);

                return $x;
            });
            $this->successMessage($lang ? 'آگهی با موفقیت حذف شد.' : "Ad deleted successfully");
        } else {
            $this->errorMessage($lang ? 'این آگهی پیدا نشد.' : "Ad not found.");
            $this->updateUserExtra(function ($x) use ($m) {
                unset($x->advertisementsEdit);

                return $x;
            });
        }
        $this->advertisementsListBackToIt($t, $u, $m);
    }
}
