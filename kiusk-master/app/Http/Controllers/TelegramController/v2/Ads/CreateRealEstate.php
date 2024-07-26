<?php

namespace App\Http\Controllers\TelegramController\v2\Ads;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\Room;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\SalePrice;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\RentPrice;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\Area;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\AreaUnit;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\Bathroom;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\YearlyTax;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\KeepingPrice;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\ConstructionYear;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\AvailabilityDate;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\MainFacility;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\NearbyFacility;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\BuildingFacility;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\UnitFacility;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\MortgagePrice;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\Floor;
use App\Http\Controllers\TelegramController\v2\Ads\CreateFields\RealEstate\Parking;
use App\Http\Controllers\TelegramController\v2\Methods;
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

trait CreateRealEstate
{
    use Room;
    use SalePrice;
    use RentPrice;
    use Area;
    use AreaUnit;
    use Bathroom;
    use YearlyTax;
    use KeepingPrice;
    use ConstructionYear;
    use AvailabilityDate;
    use MainFacility;
    use NearbyFacility;
    use BuildingFacility;
    use UnitFacility;
    use Parking;
    use MortgagePrice;
    use Floor;
    use Methods;

    public function realEstateLastStep(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $this->setLanguage();
        $text = st()->adCreatePreviewText;
        // $text = __("Information has been successfully registered. Use the \"Send for confirmation and display\" button to save and final registration.");
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => $text,
            'reply_markup' => $this->returnToHomeKeyboard()
        ]);
        $text = $this->realEstateCreatePreviewText();
        $b11 = Keyboard::inlineButton([
            'text' => st()->adsCreateKeyboard[8]['keyName'],
            'callback_data' => 'realEstateCreateSendAndStore',
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
            'callback_data' => 'realEstateCreateSendAndStore'
        ]));
    }

    public function realEstateCreateKeyboard(): Keyboard
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
        $count = auth()
            ->user()
            ->getMedia('adsCreateGallery')
            ->count();
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

    public function realEstateCreateSendAndStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $adcreate = auth()->user()->extra->adsCreate;
        $isApplicant = auth()->user()?->getRoleNames()?->first() === 'property_applicant';
        $data = json_decode(json_encode($adcreate), true);
        $validation = \Validator::make($data, [
            'title' => 'required|' . st()->adsCreateKeyboard[1]['keyRule'],
            'title_en' => 'required|' . st()->adsCreateKeyboard[9]['keyRule'],
            'content' => 'required|' . st()->adsCreateKeyboard[3]['keyRule'],
            'content_en' => 'required|' . st()->adsCreateKeyboard[10]['keyRule'],
            'state_id' => 'required',
            'category_id' => 'required',
            'rooms' => 'required|' . st()->realEstateCreateKeyboard[0]['keyRule'],
            'sale_price' => 'nullable|numeric|' . st()->realEstateCreateKeyboard[1]['keyRule'],
            'rent_price' => 'nullable|numeric|' . st()->realEstateCreateKeyboard[2]['keyRule'],
            'area' => 'required|numeric|' . st()->realEstateCreateKeyboard[3]['keyRule'],
            'area_unit' => 'required|' . st()->realEstateCreateKeyboard[4]['keyRule'],
            'bathroom' => 'required|numeric|' . st()->realEstateCreateKeyboard[5]['keyRule'],
            'yearly_tax' => 'nullable|numeric|' . st()->realEstateCreateKeyboard[6]['keyRule'],
            'price_keep' => 'nullable|numeric|' . st()->realEstateCreateKeyboard[7]['keyRule'],
            'construction_year' => 'nullable|numeric|' . st()->realEstateCreateKeyboard[8]['keyRule'],
            'availability_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:today|' . st()->realEstateCreateKeyboard[9]['keyRule'],
            'main_facility' => 'nullable|' . st()->realEstateCreateKeyboard[10]['keyRule'],
            'nearby_facility' => 'nullable|' . st()->realEstateCreateKeyboard[11]['keyRule'],
            'building_facility' => 'nullable|' . st()->realEstateCreateKeyboard[12]['keyRule'],
            'unit_facility' => 'nullable|' . st()->realEstateCreateKeyboard[13]['keyRule'],
            'mortgage_price' => 'nullable|numeric|' . st()->realEstateCreateKeyboard[14]['keyRule'],
            'floor' => 'nullable|numeric|' . st()->realEstateCreateKeyboard[15]['keyRule'],
            'parking' => 'nullable|' . st()->realEstateCreateKeyboard[16]['keyRule'],
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
                    'sale_type' => $adcreate->sale_type,
                    'is_property_applicant' => $isApplicant
                ]);

                $ad->categories()
                    ->attach($adcreate->category_id, ['is_main' => true]);

                $ad->realEstateDetail()->create([
                    'rooms' => isset($adcreate->rooms) ? $adcreate->rooms : 0,
                    'sale_price' => isset($adcreate->sale_price) ? $adcreate->sale_price : 0,
                    'rent_price' => isset($adcreate->rent_price) ? $adcreate->rent_price : 0,
                    'area' => isset($adcreate->area) ? $adcreate->area : 0,
                    'area_unit' => isset($adcreate->area_unit) ? $adcreate->area_unit : 0,
                    'bathroom' => isset($adcreate->bathroom) ? $adcreate->bathroom : 0,
                    'yearly_tax' => isset($adcreate->yearly_tax) ? $adcreate->yearly_tax : 0,
                    'price_keep' => isset($adcreate->price_keep) ? $adcreate->price_keep : 0,
                    'construction_year' => isset($adcreate->construction_year) ? $adcreate->construction_year : 0,
                    'availability_date' => isset($adcreate->availability_date) ? $adcreate->availability_date : 0,
                    'mortgage_price' => isset($adcreate->mortgage_price) ? $adcreate->mortgage_price : 0,
                    'floor' => isset($adcreate->floor) ? $adcreate->floor : 0,
                ]);

                $parking = isset($adcreate->parking) ? $adcreate->parking : [];
                $unit_facilities = isset($adcreate->unit_facilities) ? $adcreate->unit_facilities : [];
                $building_facilities = isset($adcreate->building_facilities) ? $adcreate->building_facilities : [];
                $nearby_facilities = isset($adcreate->nearby_facilities) ? $adcreate->nearby_facilities : [];
                $facilities = isset($adcreate->facilities) ? $adcreate->facilities : [];

                $mergedFacilities = array_merge(
                    $parking,
                    $unit_facilities,
                    $building_facilities,
                    $nearby_facilities,
                    $facilities
                );
                $ad->facilities()->attach($mergedFacilities);
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
                    $ad->addMediaFromUrl('https://via.placeholder.com/150')->toMediaCollection('SpecialImage');
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

                DB::commit();

                $message = st()->adsCreateSuccess;
                $lang = App::isLocale('fa') ? '' : 'en.';
                $smsMessage = __('messages.telegram.createAdSmsText', [
                    'title' => $ad->locale_title,
                    'link' =>  route($lang . 'front.ad.show', $ad->slug)
                ]);
                app(\App\Services\Sms\SmsService::class)->sendMessage(auth()->user()->phone, $smsMessage);

                $this->successMessage($message);
                $this->startRemoveKeyboard($t, $u);
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

    public function realEstateCreatePreviewText(): string
    {
        $text = "";
        $adsCreate = auth()->user()?->extra?->adsCreate ?? null;
        if ($adsCreate) {
            $count = auth()
                ->user()
                ->getMedia('adsCreateGallery')
                ->count();

            $parking = 0;
            $maiFacilities = 0;
            $nearbyFacilities = 0;
            $buildingFacilities = 0;
            $unitFacilities = 0;

            if(isset($adsCreate->parking))
                $parking = is_array($adsCreate?->parking) ? count($adsCreate?->parking) : 0;
            if(isset($adsCreate->facilities))
                $maiFacilities = is_array($adsCreate?->facilities) ? count($adsCreate?->facilities) : 0;
            if(isset($adsCreate?->nearby_facilities))
                $nearbyFacilities = is_array($adsCreate?->nearby_facilities) ? count($adsCreate?->nearby_facilities) : 0;
            if(isset($adsCreate->building_facilities))
                $buildingFacilities = is_array($adsCreate?->building_facilities) ? count($adsCreate?->building_facilities) : 0;
            if(isset($adsCreate->unit_facilities))
                $unitFacilities = is_array($adsCreate?->unit_facilities) ? count($adsCreate?->unit_facilities) : 0;
            if($adsCreate->sale_type === 'rent'){
                $text = __('messages.telegram.adsRealEstateRentCreatePreview', [
                    'category' => isset($adsCreate->category_id) ? \App\Models\Ad\Category::find($adsCreate->category_id)->locale_name : '❌',
                    'title' => $adsCreate->title,
                    'title_en' => $adsCreate->title_en,
                    'content' => $adsCreate->content,
                    'content_en' => $adsCreate->content_en,
                    'state' => isset($adsCreate->state_id) ? \App\Models\Address\State::find($adsCreate->state_id)->name : '❌',
                    'city' => isset($adsCreate->city_id) ? \App\Models\Address\City::find($adsCreate->city_id)->name : '❌',
                    'image' =>  $count ? (auth()?->user()?->isLangFa() ? "تعداد عکس ها: " : "Pictures count: ") . $count . '✅' : '❌',
                    'mortgage_price' => isset($adsCreate->mortgage_price) ? $adsCreate->mortgage_price : null,
                    'rent_price' => isset($adsCreate->rent_price) ? $adsCreate->rent_price : null ,
                    'area' => isset($adsCreate->area) ? $adsCreate->area : null,
                    'areaUnit' => __('messages.area_unit.' . $adsCreate->area_unit),
                    'floor' => isset($adsCreate->floor) ? $adsCreate->floor : null,
                    'rooms' => $adsCreate->rooms,
                    'bathrooms' => $adsCreate->bathroom,
                    'construction_year' => $adsCreate->construction_year,
                    'availability_date' => $adsCreate->availability_date,
                    'parking' => $parking,
                    'facilities' => $maiFacilities,
                    'nearby_facilities' => $nearbyFacilities,
                    'building_facilities' => $buildingFacilities,
                    'unit_facilities' => $unitFacilities,
                ]);
            }else{
                $text = __('messages.telegram.adsRealEstateSaleCreatePreview', [
                    'category' => isset($adsCreate->category_id) ? \App\Models\Ad\Category::find($adsCreate->category_id)->locale_name : '❌',
                    'title' => $adsCreate->title,
                    'title_en' => $adsCreate->title_en,
                    'content' => $adsCreate->content,
                    'content_en' => $adsCreate->content_en,
                    'state' => isset($adsCreate->state_id) ? \App\Models\Address\State::find($adsCreate->state_id)->name : '❌',
                    'city' => isset($adsCreate->city_id) ? \App\Models\Address\City::find($adsCreate->city_id)->name : '❌',
                    'image' =>  $count ? (auth()?->user()?->isLangFa() ? "تعداد عکس ها: " : "Pictures count: ") . $count . '✅' : '❌',
                    'sale_price' => $adsCreate->sale_price,
                    'price_keep' => $adsCreate->price_keep,
                    'yearly_tax' => $adsCreate->yearly_tax,
                    'area' => $adsCreate->area,
                    'areaUnit' => __('messages.area_unit.' . $adsCreate->area_unit),
                    'floor' => $adsCreate->floor,
                    'rooms' => $adsCreate->rooms,
                    'bathrooms' => $adsCreate->bathroom,
                    'construction_year' => $adsCreate->construction_year,
                    'availability_date' => $adsCreate->availability_date,
                    'parking' => $parking,
                    'facilities' => $maiFacilities,
                    'nearby_facilities' => $nearbyFacilities,
                    'building_facilities' => $buildingFacilities,
                    'unit_facilities' => $unitFacilities,
                ]);
            }
        }
        return $text;
    }
}
