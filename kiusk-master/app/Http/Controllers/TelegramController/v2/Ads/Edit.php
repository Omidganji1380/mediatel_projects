<?php

namespace App\Http\Controllers\TelegramController\v2\Ads;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\Attr;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\Category;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\City;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\Content;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\FeaturedAd;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\Gallery;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\Price;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\State;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\Title;
use App\Http\Controllers\TelegramController\v2\Methods;
use App\Models\Ad\Ad;
use App\Models\Ad\Attribute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
    use Title;
    use Price;
    use Content;
    use State;
    use City;
    use Gallery;
    use Category;
    use Attr;
    use FeaturedAd;
    use EditRealEstate;
    use Methods;

    public $type;
    public $sale_type;

    public function adsEdit(Api $t, Update $u, $id = null): void
    {
        $user = auth()->user();
        $list = [
            'لطفا عکس پروفایل خود را ارسال کنید',
            'لطفا عکس های جدید را ارسال کنید.',
            'لطفا عکس ها را ارسال کنید.',
        ];
        if (!in_array($user->telegram_last_message, $list)) {
            $user->update([
                'telegram_last_message' => null,
                'telegram_last_method' => null,
            ]);
        }
        if (!isset(auth()->user()->extra->adsAcceptTheRulesMessageId)) {
            $this->adsAcceptTheRules($t, $u);

            return;
        };
        $this->updateUserExtra(function ($x) use ($id) {
            if (!isset($x->adsEdit)) {
                $x->adsEdit = new stdClass();
            }
            if ($id) {
                $ad = Ad::whereUserId(auth()->id())
                    ->whereId($id)
                    ->first();
                if ($ad) {
                    $ad->append([
                        'content_strip',
                    ]);
                    $x->adsEdit = $ad;
                    $x->adsEdit->type = $this->type = $ad->mainCategory?->first()?->type;
                    $x->adsEdit->sale_type = $this->sale_type = $ad->mainCategory?->first()?->sale_type;
                    if ($this->type === 'real_estate' && $ad->realEstateDetail) {
                        $x->adsEdit->rooms = $ad->realEstateDetail->rooms;
                        $x->adsEdit->sale_price = $ad->realEstateDetail->sale_price;
                        $x->adsEdit->rent_price = $ad->realEstateDetail->rent_price;
                        $x->adsEdit->price_keep = $ad->realEstateDetail->price_keep;
                        $x->adsEdit->area = $ad->realEstateDetail->area;
                        $x->adsEdit->area_unit = $ad->realEstateDetail->area_unit;
                        $x->adsEdit->bathroom = $ad->realEstateDetail->bathroom;
                        $x->adsEdit->yearly_tax = $ad->realEstateDetail->yearly_tax;
                        $x->adsEdit->construction_year = $ad->realEstateDetail->construction_year;
                        $x->adsEdit->availability_date = $ad->realEstateDetail->availability_date->format('Y-m-d');
                        $x->adsEdit->mortgage_price = $ad->realEstateDetail->mortgage_price;
                        $x->adsEdit->floor = $ad->realEstateDetail->floor;
                        $x->adsEdit->elevator = $ad->realEstateDetail->elevator;
                        $x->adsEdit->warehouse = $ad->realEstateDetail->warehouse;
                        $x->adsEdit->balcony = $ad->realEstateDetail->balcony;
                    }

                    if ($ad->facilities) {
                        $facilities = $ad->facilities?->where('type', 'facility')->pluck('id')->toArray() ?? [];
                        $nearbyFacilities = $ad->nearbyFacilities?->where('type', 'nearby_facility')->pluck('id')->toArray() ?? [];
                        $buildingFacilities = $ad->buildingFacilities?->where('type', 'building_facility')->pluck('id')->toArray() ?? [];
                        $unitFacilities = $ad->unitFacilities?->where('type', 'unit_facility')->pluck('id')->toArray() ?? [];
                        $parkings = $ad->parkings?->where('type', 'parking')->pluck('id')->toArray() ?? [];
                        $x->adsEdit->facilities = $facilities;
                        $x->adsEdit->nearby_facilities = $nearbyFacilities;
                        $x->adsEdit->building_facilities = $buildingFacilities;
                        $x->adsEdit->unit_facilities = $unitFacilities;
                        $x->adsEdit->parking = $parkings;
                    }
                    $user = auth()->user();
                    $user->getMedia('adsEditGallery')
                        ->each(function ($item) {
                            $item->delete();
                        });
                    $medias = Media::whereModelId($id)
                        ->whereModelType('ad')
                        ->whereIn('collection_name', [
                            'gallery',
                            'SpecialImage',
                        ])
                        ->get();
                    $medias->each(function ($item) use ($user) {
                        $item->copy($user, 'adsEditGallery');
                    });
                }
            }

            return $x;
        });

        if ($this->type === 'real_estate' || auth()->user()?->extra?->adsEdit?->type === 'real_estate') {
            $adsEditKeyboard = $this->realEstateEditKeyboard();
        } else {
            $adsEditKeyboard = $this->adsEditKeyboard();
        }
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => st()->adsEditText . $this->flashMassage(),
            'reply_markup' => $adsEditKeyboard,
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function adsEditKeyboard(): Keyboard
    {
        /**
         * @var $newAd Ad
         * */
        $user = auth()->user();
        $newAd = $user->extra->adsEdit;
        if (!isset($newAd->category_id)) {
            $ad = Ad::find($newAd->id);
            if ($ad) {
                $category = $ad->mainCategory()
                    ->first();
                if ($category) {
                    $this->updateUserExtra(function ($x) use ($category) {
                        $x->adsEdit->category_id = $category->id;

                        return $x;
                    });
                    $attrs = $ad->attrs;
                    // dump($attrs);
                    if ($attrs && $attrs->count()) {
                        $attrs->map(function ($item) {
                            $item->value = $item->pivot->text;

                            return $item;
                        });
                        $this->updateUserExtra(function ($x) use ($attrs) {
                            $x->adsEdit->attributes = $attrs;

                            return $x;
                        });
                    }
                }
            }
        }
        $name = auth()?->user()?->isLangFa() ? 'name' : 'name_en';
        if (isset($category) && $category) {
            $category_name = $category?->$name;
        } elseif (isset($newAd->category_id)) {
            $category_name = \App\Models\Ad\Category::find($newAd->category_id)->$name;
        } else {
            $category_name = '❌';
        }
        if (isset($attrs) && $attrs->count()) {
            $computedAttrs = $attrs;
        } elseif (isset($newAd->attributes)) {
            $computedAttrs = $newAd->attributes;
        }
        $b_1 = Keyboard::inlineButton([
            'text' => $category_name,
            'callback_data' => 'adsEditCategoryRequest',
        ]);
        $b1_1 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[0]['keyName'],
            'callback_data' => 'adsEditCategoryRequest',
        ]);
        $b = Keyboard::inlineButton([
            'text' => $newAd->title ?? '❌',
            'callback_data' => 'adsEditTitleRequest',
        ]);
        $b1 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[1]['keyName'],
            'callback_data' => 'adsEditTitleRequest',
        ]);
        $b14_1 = Keyboard::inlineButton([
            'text' => $newAd->title_en ?? '❌',
            'callback_data' => 'adsEditTitleEnRequest',
        ]);
        $b14_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[11]['keyName'],
            'callback_data' => 'adsEditTitleEnRequest',
        ]);
        $b_2 = Keyboard::inlineButton([
            /*
                                        * todo done for Setting
                                        * */
            'text' => $newAd->price ? (string)Money::USD($newAd->price, true) : '❌',
            'callback_data' => 'adsEditPriceRequest',
        ]);
        $b1_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[2]['keyName'],
            'callback_data' => 'adsEditPriceRequest',
        ]);
        $b2 = Keyboard::inlineButton([
            'text' => $newAd->content_strip ?? '❌',
            'callback_data' => 'adsEditContentRequest',
        ]);
        $b3 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[3]['keyName'],
            'callback_data' => 'adsEditContentRequest',
        ]);
        $b15_1 = Keyboard::inlineButton([
            'text' => $newAd->content_en ?? '❌',
            'callback_data' => 'adsEditContentEnRequest',
        ]);
        $b15_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[12]['keyName'],
            'callback_data' => 'adsEditContentEnRequest',
        ]);
        // $b16_1 = Keyboard::inlineButton([
        //                               'text' => $newAd->is_featured ? __("Yes") : __("No"),
        //                               'callback_data' => 'adsEditIsFeaturedRequest',
        //                              ]);
        // $b16_2 = Keyboard::inlineButton([
        //                               'text' => st()->adsEditKeyboard[13]['keyName'],
        //                               'callback_data' => 'adsEditIsFeaturedRequest',
        //                              ]);
        $count = $user->getMedia('adsEditGallery')
            ->count();
        if (session('numberGalleryAddOne')) {
            $count++;
            session()->forget('numberGalleryAddOne');
        }
        $b4 = Keyboard::inlineButton([
            'text' => $count ? (auth()?->user()?->isLangFa() ? "تعداد عکس ها: " : "Number of images: ") . $count . '✅' : '❌',
            'callback_data' => 'adsEditGalleryRequest',
        ]);
        $b5 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[4]['keyName'],
            'callback_data' => 'adsEditGalleryRequest',
        ]);
        $b6 = Keyboard::inlineButton([
            'text' => isset($newAd->city_id) ? \App\Models\Address\City::find($newAd->city_id)->name : '❌',
            'callback_data' => 'adsEditCityRequest',
        ]);
        $b8 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[5]['keyName'],
            'callback_data' => 'adsEditCityRequest',
        ]);
        $b9 = Keyboard::inlineButton([
            'text' => isset($newAd->state_id) ? \App\Models\Address\State::find($newAd->state_id)->name : '❌',
            'callback_data' => 'adsEditStateRequest',
        ]);
        $b10 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[6]['keyName'],
            'callback_data' => 'adsEditStateRequest',
        ]);
        $b7 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[7]['keyName'],
            'callback_data' => 'adsListBackToIt',
        ]);
        $b11 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[8]['keyName'],
            'callback_data' => 'adsEditSendAndStore',
        ]);
        // dump($newAd->id,'adsEdit');
        $b12 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[9]['keyName'],
            'callback_data' => 'adsEditDeleteConfirm' . $newAd->id,
        ]);
        $b13 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[10]['keyName'],
            //    'url' => route('front.panel.user.ad.payment', [$newAd->id]),
            'url' => route('front.panel.user.plans.index', ['ad' => $newAd->slug, "model_type" => 'ad'])
        ]);
        $b14_1 = Keyboard::inlineButton([
            'text' => __('Pin Ad'),
            'url' => route('front.panel.user.plans.pin-ads', ['ad' => $newAd->slug, "model_type" => 'pinAd'])
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($b_1, $b1_1)
            ->row($b, $b1)
            ->row($b14_1, $b14_2)
            // ->row($b_2, $b1_2)
            ->row($b2, $b3)
            ->row($b15_1, $b15_2)
            // ->row($b16_1, $b16_2)
            ->row($b4, $b5)
            ->row($b6, $b8, $b9, $b10);
        if (isset($computedAttrs) && count($computedAttrs)) {
            foreach ($computedAttrs as $attr) {
                /**
                 * @var Attribute $attr
                 */
                if ($attr?->options && count($attr->options)) {
                    $callback = 'adsEditAttributeOptionRequest';
                } else {
                    $callback = 'adsEditAttributeRequest';
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
        $keyboard->row($b12);
        $keyboard->row($b13);
        // $keyboard->row($b7);

        return $keyboard;
    }

    public function adsEditSendAndStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $adedit = auth()->user()->extra->adsEdit;
        $data = json_decode(json_encode($adedit), true);
        $validation = \Validator::make($data, [
            'title' => [
                'required',
                'min:3',
                // Rule::unique('ads', 'title')
                //     ->ignore($adedit->id),
            ],
            'content' => 'required|' . st()->adsEditKeyboard[3]['keyRule'],
            'state_id' => 'required',
        ]);
        if ($validation->fails()) {
            $this->errorMessage(implode('🚫' . PHP_EOL . '🚫', $validation->messages()
                ->all()));
            $this->adsEdit($t, $u);
        } else {
            try {
                $ad = Ad::whereId($adedit->id)
                    ->whereUserId(auth()->id())
                    ->first();
                $ad->update([
                    'title' => $adedit->title,
                    'title_en' => $adedit->title_en,
                    'slug' => $this->createUniqueSlug(Ad::class, $adedit->title_en),
                    // 'slug' => \Str::slug($adedit->title_en),
                    'content' => $adedit->content,
                    'content_en' => $adedit->content_en,
                    'is_visible' => false,
                    'seo_title' => str_split($adedit->title, 60)[0],
                    // 'seo_description' => str_split($adedit->content, 160)[0],
                    'seo_title_en' => str_split($adedit->title_en, 60)[0],
                    'seo_description_en' => str_split($adedit->content_en, 160)[0],
                    'state_id' => $adedit->state_id,
                    'city_id' => isset($adedit->city_id) ? $adedit->city_id : null,
                ]);
                /*
             *
             *
             * todo must be un comment
             *
             *  */ //dsdsdsdsd
                if (auth()
                    ->user()
                    ->getMedia('adsEditGallery')->count()
                ) {
                    auth()
                        ->user()
                        ->getMedia('adsEditGallery')
                        ->each(function ($item, $key) use ($ad) {
                            if ($key === 0) {
                                $item->move($ad, 'SpecialImage');
                            } else {
                                $item->move($ad, 'Gallery');
                            }
                        });
                } else {
                    $ad->addMediaFromUrl('https://via.placeholder.com/150')->toMediaCollection('SpecialImage');
                }
                $attrs = $ad->attrs2;
                if (isset($adedit->attributes) && count($adedit->attributes)) {
                    foreach ($adedit->attributes as $attribute) {
                        // $ad->attrs2()
                        // ->update([
                        //             'text' => isset($attribute->value) ? $attribute->value : null,
                        //             'ad_attribute_id' => $attribute->id,
                        //             ]);
                        $attrs->each(function ($item) use ($attribute) {
                            if ($item->ad_attribute_id === $attribute->id) {
                                $item->update(['text' => isset($attribute->value) ? $attribute->value : null]);
                                //   dump($item->toArray());
                            }
                        });
                    }
                }
                $this->updateUserExtra(function ($x) use ($m) {
                    unset($x->adsEdit);

                    return $x;
                });

                $ad->setStatus('pending_approval');

                $lang = App::isLocale('fa') ? '' : 'en.';
                $smsMessage = __('messages.telegram.editAdSmsText', [
                    'title' => $ad->locale_title,
                    'link' =>  route($lang . 'front.ad.show', $ad->slug)
                ]);
                app(\App\Services\Sms\SmsService::class)->sendMessage(auth()->user()->phone, $smsMessage);
                $this->successMessage(st()->adsEditSuccess);
                $this->adsListBackToIt($t, $u, $m);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $this->errorMessage('🚫' . __("messages.unknown_error_message") . '🚫');
                auth()->user()->getMedia('adsEditGallery')->each(function ($item, $key) {
                    if (!Storage::exists($item->getPath())) {
                        $item->delete();
                    }
                });
                $this->updateUserExtra(function ($x) use ($m) {
                    unset($x->adsEdit);

                    return $x;
                });
                $this->startRemoveKeyboard($t, $u);
            }
        }
    }

    public function adsEditDeleteConfirm(Api $t, Update $u, Message|Collection|EditedMessage $m, $id)
    {
        // dump($id,'adsEditDeleteConfirm');
        $b11 = Keyboard::inlineButton([
            'text' => '🚫🚫بله مطمئن هستم🚫🚫',
            'callback_data' => 'adsEditDelete' . $id,
        ]);
        $b12 = Keyboard::inlineButton([
            'text' => 'خیر',
            'callback_data' => 'adsEdit' . $id,
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($b11)
            ->row($b12);
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => st()->adsEditKeyboard[9]['keyText'],
            'reply_markup' => $keyboard,
        ]);
    }

    public function adsEditDelete(Api $t, Update $u, Message|Collection|EditedMessage $m, $id)
    {
        // dump($id,'adsEditDelete');
        $lang = auth()?->user()?->isLangFa();
        $QB = Ad::whereUserId(auth()->id())
            ->whereId($id);
        $ad = $QB->first();
        // dump($QB->explain());
        if ($ad) {
            $ad->delete();
            $this->updateUserExtra(function ($x) use ($m) {
                unset($x->adsEdit);

                return $x;
            });
            $this->successMessage($lang ? 'آگهی با موفقیت حذف شد.' : "Ad deleted successfully");
        } else {
            $this->errorMessage($lang ? 'این آگهی پیدا نشد.' : "Ad not found.");
            $this->updateUserExtra(function ($x) use ($m) {
                unset($x->adsEdit);

                return $x;
            });
        }
        $this->adsListBackToIt($t, $u, $m);
    }
}
