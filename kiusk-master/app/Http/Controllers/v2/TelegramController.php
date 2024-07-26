<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TelegramController\v2\Ads;
use App\Http\Controllers\TelegramController\v2\Advertisement;
use App\Http\Controllers\TelegramController\v2\Help;
use App\Http\Controllers\TelegramController\v2\Language;
use App\Http\Controllers\TelegramController\v2\Methods;
use App\Http\Controllers\TelegramController\v2\PinAd;
use App\Http\Controllers\TelegramController\v2\Profile;
use App\Http\Controllers\TelegramController\v2\Register;
use App\Http\Controllers\TelegramController\v2\Start;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Str;
use Telegram;
use Telegram\Bot\Api;

//use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class TelegramController extends Controller
{
    use Methods;
    use Helper;
    use Language;
    use Profile;
    use Register;
    use Ads;
    use Start;
    use Help;
    use PinAd;
    use Advertisement;
    use Helper;

    /**
     * Handles the main entry of the telegram requests
     *
     * @return void
     */
    public function index()
    {
        //  $t = new Api('5000545191:AAEQRciGRoWXjw42zwHyqJMUWaQB53WFezw');
        //  $t = new Api('6497087801:AAHiq-cQPrbQASjmGLAqud_G3pLqFKDc8cE');
        //  return response(' sefsef ');
        $t = new Api(st()->botApiToken);
        $u = $t->getWebhookUpdate();
        $m = $u->getMessage();
        if($m->has('from')){
            $from = $m?->from ?? $m->getFrom();
            switch ($u->detectType()) {
                case 'callback_query':
                    $cqf = $u->callbackQuery->from;
                    $this->login($cqf);

                    break;
                default:
                    $this->login($from);

                    break;
            }
            switch ($u->detectType()) {
                case 'message':
                    /////messaeg//////////////////////////////////////////
                    switch ($m->detectType()) {
                        /////text//////////////////////////////////////////
                        case 'text':
                            switch ($u->getMessage()->text) {
                                // Main page
                                case '/start':
                                    $this->start($t, $u);

                                    break;
                                case 'Return':
                                    $this->startRemoveKeyboard($t, $u);

                                    break;
                                case 'Return To Main Menu ↩️':
                                    $this->startRemoveKeyboard($t, $u);

                                    break;
                                case 'Create Ad ➕':
                                    $this->adsCreate($t, $u, $m);

                                    break;
                                case 'Register ®️':
                                    $this->register($t, $u, $m);

                                    break;
                                case 'My Ads 📜':
                                    $this->adsList($t, $u, $m);

                                    break;
                                case 'My profile 👤':
                                    $this->profile($t, $u, $m);

                                    break;
                                case 'Pin Ad 📌':
                                    $this->pinAd($t, $u, $m);

                                    break;
                                case 'Language 🌐':
                                    $this->language($t, $u, $m);

                                    break;
                                case 'Help 👥':
                                    $this->help($t, $u, $m);

                                    break;
                                case 'Extensive advertising in Canada 🇨🇦':
                                    $this->advertisement($t, $u, $m);

                                    break;
                                case st()->languagePersian . '🇮🇷':
                                    $this->persianLanguage($t, $u, $m);

                                    break;
                                case st()->languageEnglish . '🇨🇦':
                                    $this->englishLanguage($t, $u, $m);

                                    break;
                                case 'Clear all images':
                                    $this->adsCreateGalleryRemoveAll($t, $u, $m);

                                    break;
                                // Register
                                case 'Normal User 👤' :
                                    $this->registerNormalUser($t, $u, $m);

                                    break;
                                case 'Help 📝👤':
                                    $this->registerNormalUserGuide($t, $u, $m);

                                    break;
                                case 'Seller 🛒':
                                    $this->registerSeller($t, $u, $m);

                                    break;
                                case 'Help 📝🛒':
                                    $this->registerSellerGuide($t, $u, $m);

                                    break;
                                case 'Business Owner 💼':
                                    $this->registerBusinessOwner($t, $u, $m);

                                    break;
                                case 'Help 📝💼':
                                    $this->registerBusinessOwnerGuide($t, $u, $m);

                                    break;
                                case 'Real Estate 🏘':
                                    $this->registerRealEstate($t, $u, $m);

                                    break;
                                case 'Help 📝🏘':
                                    $this->registerRealEstateGuide($t, $u, $m);

                                    break;
                                case 'Property Applicant 🏠':
                                    $this->registerPropertyApplicant($t, $u, $m);

                                    break;
                                case 'Help 📝🏠':
                                    $this->registerPropertyApplicantGuide($t, $u, $m);

                                    break;
                                case 'VIP 👑':
                                    $this->registerVIP($t, $u, $m);

                                    break;
                                case 'Help 📝👑':
                                    $this->registerVIPGuide($t, $u, $m);

                                    break;
                                //Ads
                                case 'Skip This Step ➡️':
                                    $this->skipToMethod($t, $u, $m);

                                    break;

                                // Advertisements
                                case 'Create Advertisement ➕':
                                    $this->advertisementsCreate($t, $u, $m);

                                    break;
                                case 'Edit Advertisement ✏️':
                                    $this->advertisementsList($t, $u, $m);

                                    break;
                                case 'My Advertisements 📜':
                                    $this->advertisementsList($t, $u, $m);

                                    break;
                                case 'Advertisement Help 👥':
                                    $this->advertisementHelp($t, $u, $m);

                                    break;
                                /*********Persian Callbacks***************/

                                // Main page
                                case 'بازگشت':
                                    $this->startRemoveKeyboard($t, $u);

                                    break;
                                case 'بازگشت به منو اصلی ↩️':
                                    $this->startRemoveKeyboard($t, $u);

                                    break;
                                case "ثبت آگهی ➕":
                                    $this->adsCreate($t, $u, $m);

                                    break;
                                case 'ثبت نام ®️':
                                    $this->register($t, $u, $m);

                                    break;
                                case 'آگهی های من 📜':
                                    $this->adsList($t, $u, $m);

                                    break;
                                case "پروفایل من 👤":
                                    $this->profile($t, $u, $m);

                                    break;
                                case 'زبان 🌐':
                                    $this->language($t, $u, $m);

                                    break;
                                case 'پین کردن اگهی 📌':
                                    $this->pinAd($t, $u, $m);

                                    break;
                                case 'راهنما 👥':
                                    $this->help($t, $u, $m);

                                    break;
                                case 'تبلیغات گسترده در کانادا 🇨🇦':
                                    $this->advertisement($t, $u, $m);

                                    break;
                                case 'پاک‌ کردن همه عکس‌ها':
                                    $this->adsCreateGalleryRemoveAll($t, $u, $m);

                                    break;
                                // Register
                                case 'کاربر معمولی 👤':
                                    $this->registerNormalUser($t, $u, $m);

                                    break;
                                case 'راهنما 📝👤':
                                    $this->registerNormalUserGuide($t, $u, $m);

                                    break;
                                case 'فروشنده کالا 🛒':
                                    $this->registerSeller($t, $u, $m);

                                    break;
                                case 'راهنما 📝🛒':
                                    $this->registerSellerGuide($t, $u, $m);

                                    break;
                                case 'مالک بیزنس 💼':
                                    $this->registerBusinessOwner($t, $u, $m);

                                    break;
                                case 'راهنما 📝💼':
                                    $this->registerBusinessOwnerGuide($t, $u, $m);

                                    break;
                                case 'مشاورین املاک 🏘':
                                    $this->registerRealEstate($t, $u, $m);

                                    break;
                                case 'راهنما 📝🏘':
                                    $this->registerRealEstateGuide($t, $u, $m);

                                    break;
                                case 'متقاضی ملک 🏠':
                                    $this->registerPropertyApplicant($t, $u, $m);

                                    break;
                                case 'راهنما 📝🏘':
                                    $this->registerPropertyApplicantGuide($t, $u, $m);

                                    break;
                                case 'کاربر ویژه 👑':
                                    $this->registerVIP($t, $u, $m);

                                    break;
                                case 'راهنما 📝👑':
                                    $this->registerVIPGuide($t, $u, $m);

                                    break;
                                case 'گذر از این مرحله ⬅️':
                                    $this->skipToMethod($t, $u, $m);

                                    break;
                                case 'ساخت تبلیغ ➕':
                                    $this->advertisementsCreate($t, $u, $m);

                                    break;
                                case 'ویرایش تبلیغ ✏️':
                                    $this->advertisementsList($t, $u, $m);

                                    break;
                                case 'تبلیغات من 📜':
                                    $this->advertisementsList($t, $u, $m);

                                    break;
                                case 'راهنمای تبلیغ 👥':
                                    $this->advertisementHelp($t, $u, $m);

                                    break;
                                default:
                                    switch (auth()->user()->telegram_last_message) {
                                        default:
                                            $id = $this->routeTo($t, $u, $m);
                                    }

                                    break;
                            }

                            break;
                            /////contact//////////////////////////////////////////
                        case 'contact':
                            switch (auth()->user()->telegram_last_method) {
                                case 'sharePhone':
                                    $this->registerStore($t, $u, $m);

                                    break;
                                case 'sharePhoneForSeller':
                                    $this->storeSeller($t, $u, $m);

                                    break;
                                case 'sharePhoneForBusinessOwner':
                                    $this->storeBusinessOwner($t, $u, $m);

                                    break;
                                case 'sharePhoneForRealEstate':
                                    $this->storeRealEstate($t, $u, $m);

                                    break;
                                case 'sharePhoneForPropertyApplicant':
                                    $this->storePropertyApplicant($t, $u, $m);

                                    break;
                                case 'sharePhoneForVIP':
                                    $this->storeVip($t, $u, $m);

                                    break;
                            }

                            break;
                            switch (auth()->user()->telegram_last_message) {
                                case 'کاربر گرامی لطفا پس از تایید شماره موبایل اقدام به ثبت آگهی کنید.':
                                    $this->registerStore($t, $u, $m);

                                    break;
                                case 'Dear user, please register your ad after confirming your mobile number.':
                                    $this->registerStore($t, $u, $m);

                                    break;
                            }

                            break;

                        /////photo//////////////////////////////////////////
                        case 'photo':
                            switch (auth()->user()->telegram_last_message) {
                                default:
                                    $id = $this->routeTo($t, $u, $m);

                                    break;
                            }

                            break;
                    }

                    break;

                case 'callback_query':
                    $cq = $u->callbackQuery;
                    switch ($cq->data) {
                        // Start and register
                        case 'start':
                            $this->start($t, $u, $m);

                            break;
                        case 'startBack':
                            $this->startBack($t, $u, $m);

                            break;
                        case 'profile':
                            $this->profile($t, $u, $m);

                            break;
                        case 'language':
                            $this->language($t, $u, $m);

                            break;
                        case 'persianLanguage':
                            $this->persianLanguage($t, $u, $m);

                            break;
                        case 'englishLanguage':
                            $this->englishLanguage($t, $u, $m);

                            break;
                        case 'profileScoresRequest':
                            $this->profileScoresRequest($t, $u, $m);

                            break;
                        case 'useScoresRequest':
                            $this->useScoresRequest($t, $u, $m);

                            break;
                        case 'profileRuleRequest':
                            $this->profileRuleRequest($t, $u, $m);

                            break;
                        case 'profileFirstNameRequest':
                            $this->profileFirstNameRequest($t, $u, $m);

                            break;
                        case 'profileLastNameRequest':
                            $this->profileLastNameRequest($t, $u, $m);

                            break;
                        case 'profileFullNameRequest':
                            $this->profileFullNameRequest($t, $u, $m);

                            break;
                        case 'profileEmailRequest':
                            $this->profileEmailRequest($t, $u, $m);

                            break;
                        case 'profileAddressRequest':
                            $this->profileAddressRequest($t, $u, $m);

                            break;
                        case 'profileDescriptionRequest':
                            $this->profileDescriptionRequest($t, $u, $m);

                            break;
                        case 'profileAvatarRequest':
                            $this->profileAvatarRequest($t, $u, $m);

                            break;
                        case 'profilePasswordRequest':
                            $this->profilePasswordRequest($t, $u, $m);

                            break;
                        case 'profileReferralCodeRequest':
                            $this->profileReferralCodeRequest($t, $u, $m);

                            break;
                        case 'profileMyReferralCodeRequest':
                            $this->profileMyReferralCodeRequest($t, $u, $m);

                            break;
                        case 'profileFirstNameEditRequest':
                            $this->profileFirstNameEditRequest($t, $u, $m);

                            break;
                        case 'profileLastNameEditRequest':
                            $this->profileLastNameEditRequest($t, $u, $m);

                            break;
                        case 'profileFullNameEditRequest':
                            $this->profileFullNameEditRequest($t, $u, $m);

                            break;
                        case 'profileEmailEditRequest':
                            $this->profileEmailEditRequest($t, $u, $m);

                            break;
                        case 'profileAddressEditRequest':
                            $this->profileAddressEditRequest($t, $u, $m);

                            break;
                        case 'profileDescriptionEditRequest':
                            $this->profileDescriptionEditRequest($t, $u, $m);

                            break;
                        case 'profileAvatarEditRequest':
                            $this->profileAvatarEditRequest($t, $u, $m);

                            break;
                        case 'profilePasswordEditRequest':
                            $this->profilePasswordEditRequest($t, $u, $m);

                            break;
                        case 'profileUpgradeLevelRequest':
                            $this->profileUpgradeLevelRequest($t, $u, $m);

                            break;
                        case 'profileUpgradeToCustomerStore':
                            $this->profileUpgradeToCustomerStore($t, $u, $m);

                            break;
                        case 'profileUpgradeToSellerStore':
                            $this->profileUpgradeToSellerStore($t, $u, $m);

                            break;
                        case 'profileUpgradeToRealEstateStore':
                            $this->profileUpgradeToRealEstateStore($t, $u, $m);

                            break;
                        case 'profileUpgradeToBusinessOwnerStore':
                            $this->profileUpgradeToBusinessOwnerStore($t, $u, $m);

                            break;
                        case 'profileUpgradeToVipStore':
                            $this->profileUpgradeToVipStore($t, $u, $m);

                            break;
                        case 'profileUpgradeToPropertyApplicantStore':
                            $this->profileUpgradeToPropertyApplicantStore($t, $u, $m);

                            break;
                        case 'adsList':
                            $this->adsList($t, $u, $m);

                            break;
                        case 'adsListBackToIt':
                            $this->adsListBackToIt($t, $u, $m);

                            break;
                        case 'adsCreate':
                            $this->adsCreate($t, $u, $m);

                            break;
                        case 'adsCreateReset':
                            $this->adsCreateReset($t, $u, $m);

                            break;
                        case 'adsCreateTitleRequest':
                            $this->adsCreateTitleRequest($t, $u, $m);

                            break;
                        case 'adsCreateTitleEnRequest':
                            $this->adsCreateTitleEnRequest($t, $u, $m);

                            break;
                        case 'adsCreatePriceRequest':
                            $this->adsCreatePriceRequest($t, $u, $m);

                            break;
                        case 'adsCreateStateRequest':
                            $this->adsCreateStateRequest($t, $u, $m);

                            break;
                        case 'returnToAdsCreateStateRequest':
                            $this->returnToAdsCreateStateRequest($t, $u, $m);

                            break;
                        case 'adsCreateCityRequest':
                            $this->adsCreateCityRequest($t, $u, $m);

                            break;
                        case 'adsCreateContentRequest':
                            $this->adsCreateContentRequest($t, $u, $m);

                            break;
                        case 'adsCreateContentEnRequest':
                            $this->adsCreateContentEnRequest($t, $u, $m);

                            break;
                        case 'adsCreateCategoryRequest':
                            $this->adsCreateCategoryRequest($t, $u, $m);

                            break;
                        case 'adsCreateIsFeaturedRequest':
                            $this->adsCreateIsFeaturedRequest($t, $u, $m);

                            break;
                        case 'adsCreateGalleryRequest':
                            $this->adsCreateGalleryRequest($t, $u, $m);

                            break;
                        case 'adsCreateGalleryRemoveAll':
                            $this->adsCreateGalleryRemoveAll($t, $u, $m);

                            break;
                        case 'adsCreateConfirmImage':
                            $this->adsCreateConfirmImage($t, $u, $m);

                            break;
                        case 'adsCreateSendAndStore':
                            $this->adsCreateSendAndStore($t, $u, $m);

                            break;
                        case 'adsCreateFacilityRequest':
                            $this->adsCreateFacilityRequest($t, $u, $m);

                            break;
                        case 'adsCreateNearbyFacilityRequest':
                            $this->adsCreateNearbyFacilityRequest($t, $u, $m);

                            break;
                        case 'adsCreateBuildingFacilityRequest':
                            $this->adsCreateBuildingFacilityRequest($t, $u, $m);

                            break;
                        case 'adsCreateUnitFacilityRequest':
                            $this->adsCreateUnitFacilityRequest($t, $u, $m);

                            break;
                        case 'realEstateLastStep':
                            $this->realEstateLastStep($t, $u, $m);

                            break;
                        case 'advertisementsListBackToIt':
                            $this->advertisementsListBackToIt($t, $u, $m);

                            break;
                        case 'realEstateCreateSendAndStore':
                            $this->realEstateCreateSendAndStore($t, $u, $m);

                            break;
                        case 'advertisementsCreateUrlStore':
                            $this->advertisementsCreateUrlStore($t, $u, $m);

                            break;
                        case 'advertisementsCreateLastStep':
                            $this->advertisementsCreateLastStep($t, $u, $m);

                            break;
                        case 'advertisementsCreateSendAndStore':
                            $this->advertisementsCreateSendAndStore($t, $u, $m);

                            break;
                        case 'advertisementsEditSendAndStore':
                            $this->advertisementsEditSendAndStore($t, $u, $m);

                            break;
                        case 'advertisementsEditCategoryRequest':
                            $this->advertisementsEditCategoryRequest($t, $u, $m);

                            break;
                        case 'advertisementsEditContentRequest':
                            $this->advertisementsEditContentRequest($t, $u, $m);

                            break;
                        case 'advertisementsEditContentEnRequest':
                            $this->advertisementsEditContentEnRequest($t, $u, $m);

                            break;
                        case 'advertisementsEditUrlRequest':
                            $this->advertisementsEditUrlRequest($t, $u, $m);

                            break;
                        case 'advertisementsEditGalleryRequest':
                            $this->advertisementsEditGalleryRequest($t, $u, $m);

                            break;
                        case 'advertisementsEditGalleryEnRequest':
                            $this->advertisementsEditGalleryEnRequest($t, $u, $m);

                            break;
                        case 'adsEdit':
                            $this->adsEdit($t, $u);

                            break;
                        case 'adsEditReset':
                            $this->adsEditReset($t, $u, $m);

                            break;
                        case 'adsEditTitleRequest':
                            $this->adsEditTitleRequest($t, $u, $m);

                            break;
                        case 'adsEditTitleEnRequest':
                            $this->adsEditTitleEnRequest($t, $u, $m);

                            break;
                        case 'adsEditPriceRequest':
                            $this->adsEditPriceRequest($t, $u, $m);

                            break;
                        case 'adsEditStateRequest':
                            $this->adsEditStateRequest($t, $u, $m);

                            break;
                        case 'adsEditCityRequest':
                            $this->adsEditCityRequest($t, $u, $m);

                            break;
                        case 'adsEditContentRequest':
                            $this->adsEditContentRequest($t, $u, $m);

                            break;
                        case 'adsEditContentEnRequest':
                            $this->adsEditContentEnRequest($t, $u, $m);

                            break;
                        case 'adsEditCategoryRequest':
                            $this->adsEditCategoryRequest($t, $u, $m);

                            break;
                        case 'adsEditIsFeaturedRequest':
                            $this->adsEditIsFeaturedRequest($t, $u, $m);

                            break;
                        case 'adsEditGalleryRequest':
                            $this->adsEditGalleryRequest($t, $u, $m);

                            break;
                        case 'adsEditRoomRequest':
                            $this->adsEditRoomRequest($t, $u, $m);

                            break;
                        case 'adsEditBathroomRequest':
                            $this->adsEditBathroomRequest($t, $u, $m);

                            break;
                        case 'adsEditFloorRequest':
                            $this->adsEditFloorRequest($t, $u, $m);

                            break;
                        case 'adsEditBalconyRequest':
                            $this->adsEditBalconyRequest($t, $u, $m);

                            break;
                        case 'adsEditWarehouseRequest':
                            $this->adsEditWarehouseRequest($t, $u, $m);

                            break;
                        case 'adsEditYearlyTaxRequest':
                            $this->adsEditYearlyTaxRequest($t, $u, $m);

                            break;
                        case 'adsEditKeepingPriceRequest':
                            $this->adsEditKeepingPriceRequest($t, $u, $m);

                            break;
                        case 'adsEditMortgagePriceRequest':
                            $this->adsEditMortgagePriceRequest($t, $u, $m);

                            break;
                        case 'adsEditRentPriceRequest':
                            $this->adsEditRentPriceRequest($t, $u, $m);

                            break;
                        case 'adsEditSalePriceRequest':
                            $this->adsEditSalePriceRequest($t, $u, $m);

                            break;
                        case 'adsEditConstructionYearRequest':
                            $this->adsEditConstructionYearRequest($t, $u, $m);

                            break;
                        case 'adsEditAreaRequest':
                            $this->adsEditAreaRequest($t, $u, $m);

                            break;
                        case 'adsEditAreaUnitRequest':
                            $this->adsEditAreaUnitRequest($t, $u, $m);

                            break;
                        case 'adsEditAvailabilityDateRequest':
                            $this->adsEditAvailabilityDateRequest($t, $u, $m);

                            break;
                        case 'adsEditFacilityRequest':
                            $this->adsEditFacilityRequest($t, $u, $m);

                            break;
                        case 'adsEditNearbyFacilityRequest':
                            $this->adsEditNearbyFacilityRequest($t, $u, $m);

                            break;
                        case 'adsEditBuildingFacilityRequest':
                            $this->adsEditBuildingFacilityRequest($t, $u, $m);

                            break;
                        case 'adsEditUnitFacilityRequest':
                            $this->adsEditUnitFacilityRequest($t, $u, $m);

                            break;
                        case 'adsEditParkingRequest':
                            $this->adsEditParkingRequest($t, $u, $m);

                            break;
                        case 'realEstateEditSendAndStore':
                            $this->realEstateEditSendAndStore($t, $u, $m);

                            break;
                        case 'adsEditGalleryRemoveAll':
                            $this->adsEditGalleryRemoveAll($t, $u, $m);

                            break;
                        case 'adsEditSendAndStore':
                            $this->adsEditSendAndStore($t, $u, $m);

                            break;
                        case 'register':
                            $this->register($t, $u, $m);

                            break;
                        case 'adsEditIsFeaturedStoreYes':
                            $this->adsEditIsFeaturedStoreYes($t, $u, $m);

                            break;
                        case 'adsEditIsFeaturedStoreNo':
                            $this->adsEditIsFeaturedStoreNo($t, $u, $m);

                            break;
                        case 'adsAcceptTheRules':
                            $this->adsAcceptTheRules($t, $u, $m);
                            // no break
                        case 'advertisementsAcceptTheRules':
                            $this->advertisementsAcceptTheRules($t, $u, $m);
                            // no break
                        default:
                            $d = $cq->data;
                            $s = Str::of($d);
                            switch (true) {
                                case $s->is('adsListPage*') :
                                    $this->adsList($t, $u, $m, (int)Str::after($d, 'adsListPage'));

                                    break;
                                case $s->is('adsEditDeleteConfirm*') :
                                    $this->adsEditDeleteConfirm($t, $u, $m, (int)Str::after($d, 'adsEditDeleteConfirm'));

                                    break;
                                case $s->is('adsEditDelete*') :
                                    $this->adsEditDelete($t, $u, $m, (int)Str::after($d, 'adsEditDelete'));

                                    break;
                                case $s->is('adsEditStateStore*') :
                                    $this->adsEditStateStore($t, $u, $m, (int)Str::after($d, 'adsEditStateStore'));

                                    break;
                                case $s->is('adsEditCityStore*') :
                                    $this->adsEditCityStore($t, $u, $m, (int)Str::after($d, 'adsEditCityStore'));

                                    break;
                                case $s->is('adsEditCategoryRequest*') :
                                    $this->adsEditCategoryRequest($t, $u, $m, (int)Str::after($d, 'adsEditCategoryRequest'));

                                    break;
                                case $s->is('adsEditCategoryStore*') :
                                    $this->adsEditCategoryStore($t, $u, $m, (int)Str::after($d, 'adsEditCategoryStore'));

                                    break;
                                case $s->is('adsEditAttributeRequest*') :
                                    $this->adsEditAttributeRequest($t, $u, $m, (int)Str::after($d, 'adsEditAttributeRequest'));

                                    break;
                                case $s->is('adsEditAttributeOptionRequest*') :
                                    $this->adsEditAttributeOptionRequest($t, $u, $m, (int)Str::after($d, 'adsEditAttributeOptionRequest'));

                                    break;
                                case $s->is('adsEditAttributeOptionStore*') :
                                    $this->adsEditAttributeOptionStore($t, $u, $m, (int)Str::after($d, 'adsEditAttributeOptionStore'));

                                    break;
                                case $s->is('adsCreateStateStore*') :
                                    $this->adsCreateStateStore($t, $u, $m, (int)Str::after($d, 'adsCreateStateStore'));

                                    break;
                                case $s->is('adsCreateCityStore*') :
                                    $this->adsCreateCityStore($t, $u, $m, (int)Str::after($d, 'adsCreateCityStore'));

                                    break;
                                case $s->is('adsCreateAreaUnitStore*') :
                                    $this->adsCreateAreaUnitStore($t, $u, $m, (int)Str::after($d, 'adsCreateAreaUnitStore'));

                                    break;
                                case $s->is('adsCreateParkingStore*') :
                                    $this->adsCreateParkingStore($t, $u, $m, (int)Str::after($d, 'adsCreateParkingStore'));

                                    break;
                                case $s->is('adsCreateBuildingFacilityStore*') :
                                    $this->adsCreateBuildingFacilityStore($t, $u, $m, (int)Str::after($d, 'adsCreateBuildingFacilityStore'));

                                    break;
                                case $s->is('adsCreateFacilityStore*') :
                                    $this->adsCreateFacilityStore($t, $u, $m, (int)Str::after($d, 'adsCreateFacilityStore'));

                                    break;
                                case $s->is('adsCreateNearbyFacilityStore*') :
                                    $this->adsCreateNearbyFacilityStore($t, $u, $m, (int)Str::after($d, 'adsCreateNearbyFacilityStore'));

                                    break;
                                case $s->is('adsCreateUnitFacilityStore*') :
                                    $this->adsCreateUnitFacilityStore($t, $u, $m, (int)Str::after($d, 'adsCreateUnitFacilityStore'));

                                    break;
                                case $s->is('adsCreateCategoryRequest*') :
                                    $this->adsCreateCategoryRequest($t, $u, $m, (int)Str::after($d, 'adsCreateCategoryRequest'));

                                    break;
                                case $s->is('adsCreateCategoryStore*') :
                                    $this->adsCreateCategoryStore($t, $u, $m, (int)Str::after($d, 'adsCreateCategoryStore'));

                                    break;
                                case $s->is('adsCreateAttributeRequest*') :
                                    $this->adsCreateAttributeRequest($t, $u, $m, (int)Str::after($d, 'adsCreateAttributeRequest'));

                                    break;
                                case $s->is('adsCreateAttributeOptionRequest*') :
                                    $this->adsCreateAttributeOptionRequest($t, $u, $m, (int)Str::after($d, 'adsCreateAttributeOptionRequest'));

                                    break;
                                case $s->is('adsCreateAttributeOptionStore*') :
                                    $this->adsCreateAttributeOptionStore($t, $u, $m, (int)Str::after($d, 'adsCreateAttributeOptionStore'));

                                    break;
                                case $s->is('adsCreateIsFeaturedStore*') :
                                    $this->adsCreateIsFeaturedStore($t, $u, $m, (int)Str::after($d, 'adsCreateIsFeaturedStore'));

                                    break;
                                case $s->is('advertisementsCreateCategoryStore*') :
                                    $this->advertisementsCreateCategoryStore($t, $u, $m, Str::after($d, 'advertisementsCreateCategoryStore'));

                                    break;
                                case $s->is('advertisementsCreateUrlStore*') :
                                    $this->advertisementsCreateUrlStore($t, $u, $m, (int)Str::after($d, 'advertisementsCreateUrlStore'));

                                    break;
                                case $s->is('adsEditIsFeaturedStore*') :
                                    $this->adsEditIsFeaturedStore($t, $u, $m, (int)Str::after($d, 'adsEditIsFeaturedStore'));

                                    break;
                                case $s->is('adsEditAreaUnitStore*') :
                                    $this->adsEditAreaUnitStore($t, $u, $m, (int)Str::after($d, 'adsEditAreaUnitStore'));

                                    break;
                                case $s->is('adsEditParkingStore*') :
                                    $this->adsEditParkingStore($t, $u, $m, (int)Str::after($d, 'adsEditParkingStore'));

                                    break;
                                case $s->is('adsEditUnitFacilityStore*') :
                                    $this->adsEditUnitFacilityStore($t, $u, $m, (int)Str::after($d, 'adsEditUnitFacilityStore'));

                                    break;
                                case $s->is('adsEditBuildingFacilityStore*') :
                                    $this->adsEditBuildingFacilityStore($t, $u, $m, (int)Str::after($d, 'adsEditBuildingFacilityStore'));

                                    break;
                                case $s->is('adsEditNearbyFacilityStore*') :
                                    $this->adsEditNearbyFacilityStore($t, $u, $m, (int)Str::after($d, 'adsEditNearbyFacilityStore'));

                                    break;
                                case $s->is('adsEditFacilityStore*') :
                                    $this->adsEditFacilityStore($t, $u, $m, (int)Str::after($d, 'adsEditFacilityStore'));
                                    break;
                                case $s->is('adsEdit*') :
                                    $this->adsEdit($t, $u, (int)Str::after($d, 'adsEdit'));

                                    break;
                                case $s->is('advertisementsEditCategoryStore*') :
                                    $this->advertisementsEditCategoryStore($t, $u, $m, Str::after($d, 'advertisementsEditCategoryStore'));
                                    break;
                                case $s->is('advertisementsEditDeleteConfirm*') :
                                    $this->advertisementsEditDeleteConfirm($t, $u, $m, (int)Str::after($d, 'advertisementsEditDeleteConfirm'));

                                    break;
                                case $s->is('advertisementsEditDelete*') :
                                    $this->advertisementsEditDelete($t, $u, $m, (int)Str::after($d, 'advertisementsEditDelete'));

                                    break;
                                case $s->is('advertisementsEdit*') :
                                    $this->advertisementsEdit($t, $u, (int)Str::after($d, 'advertisementsEdit'));

                                    break;
                                case $s->is('useScoresStore*') :
                                    $this->useScoresStore($t, $u, $m,(int)Str::after($d, 'useScoresStore'));

                                    break;
                                default:
                                    $this->start($t, $u, $m);

                                    break;
                            }

                            break;
                    }

                    break;
                    //   case 'shipping_query':
                    ////    return $t->shippingQuery;
                    //   case 'pre_checkout_query':
                    ////    return $t->preCheckoutQuery;
                    //   case 'poll':
                    ////    return $t->poll;
            }
        }
    }

    /**
     * Route to the latest method user selected
     *
     * @param Api $t
     * @param Update $u
     * @param Message|Collection|EditedMessage $m
     * @return array
     */
    protected function routeTo(Api $t, Update $u, Message|Collection|EditedMessage $m): array
    {
        $method = auth()->user()->telegram_last_method;
        $id = [];
        $hasId = preg_match('#(\d+)$#', $method, $id);
        if ($method && ! $hasId) {
            $this->{$method}($t, $u, $m);
        }
        if ($method && $hasId) {
            $method = Str::replace($id[0], '', $method);
            $this->{$method}($t, $u, $m, (int)$id[0]);
        }

        return $id;
    }

    /**
     * Setting the telegram webhook
     *
     * @param Request $request
     * @param string $token
     * @return Telegram
     */
    public function setWebhook(Request $request, $token)
    {
        return $this->setWebhookFunction($token) ? "Webhook Set" : "Webhook set failed";
    }

    /**
     * Retrieving the telegram webhook
     *
     * @param Request $request
     * @return Telegram
     */
    public function getWebhook(Request $request)
    {
        return $response = Telegram::getWebhookInfo();
    }

    /**
     * Delete Telegram Webhook
     *
     * @param Request $request
     * @param string $token
     * @return Api
     */
    public function deleteWebhook(Request $request, $token)
    {
        $t = new Api($token);

        return $t->deleteWebhook();
    }

    /**
     * Reset Telegram Webhook
     *
     * @param Request $request
     * @param string $token
     * @return array
     */
    public function resetWebhook(Request $request, $token)
    {
        $t = new Api($token);
        $t->deleteWebhook();
        $updates = $this->getUpdatesFunction($request, $token);
        $response = Telegram::getWebhookInfo();
        $response2 = $this->setWebhookFunction($token);

        return [
            $t,
            $updates,
            $response,
            $response2,
        ];
    }

    /**
     * Retrieve the telegram updates manually
     *
     * @param Request $request
     * @param string $token
     * @return Api
     */
    public function getUpdates(Request $request, $token)
    {
        return $this->getUpdatesFunction($request, $token);
    }

    /**
     * Make the request to get updates of telegram
     *
     * @param Request $request
     * @param string $token
     * @return Api
     */
    public function getUpdatesFunction(Request $request, $token)
    {
        $t = new Api($token);

        $offset = $request->offset ?? 423501055;

        return $t->getUpdates(['offset' => $offset]);
    }

    /**
     * Setting the telegram webhook
     *
     * @param [type] $token
     * @return Telegram
     */
    public function setWebhookFunction($token)
    {
        $url = env('APP_URL');
        return Telegram::setWebhook(['url' => "$url/" . $token ]);
    }
}
