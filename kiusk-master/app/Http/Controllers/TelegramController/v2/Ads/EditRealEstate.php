<?php

namespace App\Http\Controllers\TelegramController\v2\Ads;

use Akaunting\Money\Money;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\Room;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\SalePrice;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\RentPrice;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\Area;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\AreaUnit;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\Bathroom;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\YearlyTax;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\KeepingPrice;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\ConstructionYear;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\AvailabilityDate;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\MainFacility;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\NearbyFacility;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\BuildingFacility;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\UnitFacility;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\MortgagePrice;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\Floor;
use App\Http\Controllers\TelegramController\v2\Ads\EditFields\RealEstate\Parking;
use App\Http\Controllers\TelegramController\v2\Methods;
use App\Models\Ad\Ad;
use App\Models\Ad\Attribute;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait EditRealEstate
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

    public function realEstateEditLastStep(Api $t, Update $u, Message|Collection|EditedMessage $m)
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



    public function realEstateEditKeyboard(): Keyboard
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
        $category_1 = Keyboard::inlineButton([
            'text' => $category_name,
            'callback_data' => 'adsEditCategoryRequest',
        ]);
        $category_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[0]['keyName'],
            'callback_data' => 'adsEditCategoryRequest',
        ]);
        $title_1 = Keyboard::inlineButton([
            'text' => $newAd->title ?? '❌',
            'callback_data' => 'adsEditTitleRequest',
        ]);
        $title_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[1]['keyName'],
            'callback_data' => 'adsEditTitleRequest',
        ]);
        $titleEn_1 = Keyboard::inlineButton([
            'text' => $newAd->title_en ?? '❌',
            'callback_data' => 'adsEditTitleEnRequest',
        ]);
        $titleEn_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[11]['keyName'],
            'callback_data' => 'adsEditTitleEnRequest',
        ]);
        $content_1 = Keyboard::inlineButton([
            'text' => $newAd->content_strip ?? '❌',
            'callback_data' => 'adsEditContentRequest',
        ]);
        $content_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[3]['keyName'],
            'callback_data' => 'adsEditContentRequest',
        ]);
        $contentEn_1 = Keyboard::inlineButton([
            'text' => $newAd->content_en ?? '❌',
            'callback_data' => 'adsEditContentEnRequest',
        ]);
        $contentEn_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[12]['keyName'],
            'callback_data' => 'adsEditContentEnRequest',
        ]);
        $count = $user->getMedia('adsEditGallery')
            ->count();
        if (session('numberGalleryAddOne')) {
            $count++;
            session()->forget('numberGalleryAddOne');
        }
        $gallery_1 = Keyboard::inlineButton([
            'text' => $count ? (auth()?->user()?->isLangFa() ? "تعداد عکس ها: " : "Number of images: ") . $count . '✅' : '❌',
            'callback_data' => 'adsEditGalleryRequest',
        ]);
        $gallery_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[4]['keyName'],
            'callback_data' => 'adsEditGalleryRequest',
        ]);
        $city_1 = Keyboard::inlineButton([
            'text' => isset($newAd->city_id) ? \App\Models\Address\City::find($newAd->city_id)->name : '❌',
            'callback_data' => 'adsEditCityRequest',
        ]);
        $city_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[5]['keyName'],
            'callback_data' => 'adsEditCityRequest',
        ]);
        $state_1 = Keyboard::inlineButton([
            'text' => isset($newAd->state_id) ? \App\Models\Address\State::find($newAd->state_id)->name : '❌',
            'callback_data' => 'adsEditStateRequest',
        ]);
        $state_2 = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[6]['keyName'],
            'callback_data' => 'adsEditStateRequest',
        ]);
        $backToList = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[7]['keyName'],
            'callback_data' => 'adsListBackToIt',
        ]);
        $realEstateSendAndStore = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[8]['keyName'],
            'callback_data' => 'realEstateEditSendAndStore',
        ]);
        $adsEditDeleteConfirm = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[9]['keyName'],
            'callback_data' => 'adsEditDeleteConfirm' . $newAd->id,
        ]);
        $promot = Keyboard::inlineButton([
            'text' => st()->adsEditKeyboard[10]['keyName'],
            //    'url' => route('front.panel.user.ad.payment', [$newAd->id]),
            'url' => route('front.panel.user.plans.index', ['ad' => $newAd->slug, "model_type" => 'ad'])
        ]);

        $rooms1 = Keyboard::inlineButton([
            'text' => $newAd->rooms ?? '❌',
            'callback_data' => 'adsEditRoomRequest',
        ]);
        $rooms2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[0]['keyName'],
            'callback_data' => 'adsEditRoomRequest',
        ]);
        $bathroom_1 = Keyboard::inlineButton([
            'text' => $newAd->bathroom ?? '❌',
            'callback_data' => 'adsEditBathroomRequest',
        ]);
        $bathroom_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[5]['keyName'],
            'callback_data' => 'adsEditBathroomRequest',
        ]);
        $floor_1 = Keyboard::inlineButton([
            'text' => $newAd->floor ?? '❌',
            'callback_data' => 'adsEditFloorRequest',
        ]);
        $floor_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[15]['keyName'],
            'callback_data' => 'adsEditFloorRequest',
        ]);
        $yearlyTax_1 = Keyboard::inlineButton([
            'text' => $newAd->yearly_tax ?? '❌',
            'callback_data' => 'adsEditYearlyTaxRequest',
        ]);
        $yearlyTax_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[6]['keyName'],
            'callback_data' => 'adsEditYearlyTaxRequest',
        ]);
        $keepingPrice_1 = Keyboard::inlineButton([
            'text' => $newAd->price_keep ?? '❌',
            'callback_data' => 'adsEditKeepingPriceRequest',
        ]);
        $keepingPrice_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[7]['keyName'],
            'callback_data' => 'adsEditKeepingPriceRequest',
        ]);
        $mortgagePrice_1 = Keyboard::inlineButton([
            'text' => $newAd->mortgage_price ?? '❌',
            'callback_data' => 'adsEditMortgagePriceRequest',
        ]);
        $mortgagePrice_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[14]['keyName'],
            'callback_data' => 'adsEditMortgagePriceRequest',
        ]);
        $rentPrice_1 = Keyboard::inlineButton([
            'text' => $newAd->rent_price ?? '❌',
            'callback_data' => 'adsEditRentPriceRequest',
        ]);
        $rentPrice_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[2]['keyName'],
            'callback_data' => 'adsEditRentPriceRequest',
        ]);
        $salePrice_1 = Keyboard::inlineButton([
            'text' => $newAd->sale_price ?? '❌',
            'callback_data' => 'adsEditSalePriceRequest',
        ]);
        $salePrice_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[1]['keyName'],
            'callback_data' => 'adsEditSalePriceRequest',
        ]);
        $constructionYear_1 = Keyboard::inlineButton([
            'text' => $newAd->construction_year ?? '❌',
            'callback_data' => 'adsEditConstructionYearRequest',
        ]);
        $constructionYear_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[8]['keyName'],
            'callback_data' => 'adsEditConstructionYearRequest',
        ]);
        $area_1 = Keyboard::inlineButton([
            'text' => $newAd->area ?? '❌',
            'callback_data' => 'adsEditAreaRequest',
        ]);
        $area_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[3]['keyName'],
            'callback_data' => 'adsEditAreaRequest',
        ]);
        $areaUnit_1 = Keyboard::inlineButton([
            'text' => isset($newAd->area_unit) && !is_null($newAd->area_unit) ? __('messages.area_unit.' . $newAd->area_unit) : '❌',
            'callback_data' => 'adsEditAreaUnitRequest',
        ]);
        $areaUnit_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[4]['keyName'],
            'callback_data' => 'adsEditAreaUnitRequest',
        ]);
        $availabilityDate_1 = Keyboard::inlineButton([
            'text' => $newAd->availability_date ?? '❌',
            'callback_data' => 'adsEditAvailabilityDateRequest',
        ]);
        $availabilityDate_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[9]['keyName'],
            'callback_data' => 'adsEditAvailabilityDateRequest',
        ]);
        $facility_1 = Keyboard::inlineButton([
            'text' => isset($newAd->facilities)  &&  count($newAd->facilities) ? count($newAd->facilities)  . '✅'  : '❌',
            'callback_data' => 'adsEditFacilityRequest',
        ]);
        $facility_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[10]['keyName'],
            'callback_data' => 'adsEditFacilityRequest',
        ]);
        $nearbyFacility_1 = Keyboard::inlineButton([
            'text' => isset($newAd->nearby_facilities)  &&  count($newAd->nearby_facilities) ? count($newAd->nearby_facilities)  . '✅'  : '❌',
            'callback_data' => 'adsEditNearbyFacilityRequest',
        ]);
        $nearbyFacility_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[11]['keyName'],
            'callback_data' => 'adsEditNearbyFacilityRequest',
        ]);
        $buildingFacility_1 = Keyboard::inlineButton([
            'text' => isset($newAd->building_facilities)  &&  count($newAd->building_facilities) ? count($newAd->building_facilities)  . '✅'  : '❌',
            'callback_data' => 'adsEditBuildingFacilityRequest',
        ]);
        $buildingFacility_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[12]['keyName'],
            'callback_data' => 'adsEditBuildingFacilityRequest',
        ]);
        $unitFacility_1 = Keyboard::inlineButton([
            'text' => isset($newAd->unit_facilities)  &&  count($newAd->unit_facilities) ? count($newAd->unit_facilities)  . '✅'  : '❌',
            'callback_data' => 'adsEditUnitFacilityRequest',
        ]);
        $unitFacility_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[13]['keyName'],
            'callback_data' => 'adsEditUnitFacilityRequest',
        ]);
        $parking_1 = Keyboard::inlineButton([
            'text' => isset($newAd->parking) && count($newAd->parking) ? count($newAd->parking)  . '✅'  : '❌',
            'callback_data' => 'adsEditParkingRequest',
        ]);
        $parking_2 = Keyboard::inlineButton([
            'text' => st()->realEstateEditKeyboard[16]['keyName'],
            'callback_data' => 'adsEditParkingRequest',
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($category_1, $category_2)
            ->row($title_1, $title_2)
            ->row($titleEn_1, $titleEn_2)
            ->row($content_1, $content_2)
            ->row($contentEn_1, $contentEn_2)
            ->row($gallery_1, $gallery_2)
            ->row($state_1, $state_2, $city_1, $city_2);
        if ($this->sale_type === 'rent') {
            $keyboard->row($mortgagePrice_1, $mortgagePrice_2, $rentPrice_1, $rentPrice_2);
        } else {
            $keyboard->row($salePrice_1, $salePrice_2, $yearlyTax_1, $yearlyTax_2);
            $keyboard->row($keepingPrice_1, $keepingPrice_2);
        }
        $keyboard->row($availabilityDate_1, $availabilityDate_2)
            ->row($floor_1, $floor_2, $constructionYear_1, $constructionYear_2)
            ->row($area_1, $area_2, $areaUnit_1, $areaUnit_2)
            ->row($rooms1, $rooms2, $bathroom_1, $bathroom_2);



        $keyboard->row($facility_1, $facility_2, $nearbyFacility_1, $nearbyFacility_2)
            ->row($buildingFacility_1, $buildingFacility_2, $unitFacility_1, $unitFacility_2)
            ->row($parking_1, $parking_2);
        $keyboard->row($realEstateSendAndStore);
        $keyboard->row($adsEditDeleteConfirm);
        $keyboard->row($promot);
        $keyboard->row($backToList);

        return $keyboard;
    }

    public function realEstateEditSendAndStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $adedit = auth()->user()->extra->adsEdit;
        $data = json_decode(json_encode($adedit), true);
        $validation = \Validator::make($data, [
            'title' => 'required|' . st()->adsEditKeyboard[1]['keyRule'],
            'title_en' => 'required|' . st()->adsEditKeyboard[9]['keyRule'],
            'content' => 'required|' . st()->adsEditKeyboard[3]['keyRule'],
            'content_en' => 'required|' . st()->adsEditKeyboard[10]['keyRule'],
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
                    // 'slug' => \Str::slug($adedit->title_en ?? $adedit->title),
                    'content' => $adedit->content,
                    'content_en' => $adedit->content_en,
                    'is_visible' => false,
                    'user_id' => auth()->id(),
                    'seo_title' => str_split($adedit->title, 60)[0],
                    'seo_description' => str_split($adedit->content, 160)[0],
                    'state_id' => $adedit->state_id,
                    'city_id' => isset($adedit->city_id) ? $adedit->city_id : null,
                ]);

                $ad->realEstateDetail()->update([
                    'rooms' => $adedit->rooms,
                    'sale_price' => $adedit->sale_price,
                    'rent_price' => $adedit->rent_price,
                    'area' => $adedit->area,
                    'area_unit' => $adedit->area_unit,
                    'bathroom' => $adedit->bathroom,
                    'yearly_tax' => $adedit->yearly_tax,
                    'price_keep' => $adedit->price_keep,
                    'construction_year' => $adedit->construction_year,
                    'availability_date' => $adedit->availability_date,
                    'mortgage_price' => $adedit->mortgage_price,
                    'floor' => $adedit->floor,
                ]);

                $ad->categories()
                    ->sync($adedit->category_id, ['is_main' => true]);

                    $parking = isset($adedit->parking) ? $adedit->parking : [];
                    $unit_facilities = isset($adedit->unit_facilities) ? $adedit->unit_facilities : [];
                    $building_facilities = isset($adedit->building_facilities) ? $adedit->building_facilities : [];
                    $nearby_facilities = isset($adedit->nearby_facilities) ? $adedit->nearby_facilities : [];
                    $facilities = isset($adedit->facilities) ? $adedit->facilities : [];

                $mergedFacilities = array_merge(
                    $parking,
                    $unit_facilities,
                    $building_facilities,
                    $nearby_facilities,
                    $facilities
                );
                $ad->facilities()->sync($mergedFacilities);

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


                $this->updateUserExtra(function ($x) use ($m) {
                    unset($x->adsEdit);

                    return $x;
                });

                $message = st()->adsEditSuccess;
                $lang = App::isLocale('fa') ? '' : 'en.';
                $smsMessage = __('messages.telegram.editAdSmsText', [
                    'title' => $ad->locale_title,
                    'link' =>  route($lang . 'front.ad.show', $ad->slug)
                ]);
                app(\App\Services\Sms\SmsService::class)->sendMessage(auth()->user()->phone, $smsMessage);

                $this->successMessage($message);
                $this->startRemoveKeyboard($t, $u);
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

    public function realEstateEditPreviewText(): string
    {
        $text = "";
        $adsEdit = auth()->user()?->extra?->adsEdit ?? null;
        if ($adsEdit) {
            $count = auth()
                ->user()
                ->getMedia('adsEditGallery')
                ->count();
            $text = __('messages.telegram.adsRealEstateEditPreview', [
                'category' => isset($adsEdit->category_id) ? \App\Models\Ad\Category::find($adsEdit->category_id)->locale_name : '❌',
                'title' => $adsEdit->title,
                'title_en' => $adsEdit->title_en,
                'content' => $adsEdit->content,
                'content_en' => $adsEdit->content_en,
                'state' => isset($adsEdit->state_id) ? \App\Models\Address\State::find($adsEdit->state_id)->name : '❌',
                'city' => isset($adsEdit->city_id) ? \App\Models\Address\City::find($adsEdit->city_id)->name : '❌',
                'image' =>  $count ? (auth()?->user()?->isLangFa() ? "تعداد عکس ها: " : "Pictures count: ") . $count . '✅' : '❌'
            ]);
        }
        return $text;
    }
}
