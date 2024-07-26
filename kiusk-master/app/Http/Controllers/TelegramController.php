<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TelegramController\Ads;
use App\Http\Controllers\TelegramController\Language;
use App\Http\Controllers\TelegramController\Methods;
use App\Http\Controllers\TelegramController\Profile;
use App\Http\Controllers\TelegramController\Register;
use App\Http\Controllers\TelegramController\Start;
use App\Traits\Helper;
use Illuminate\Support\Collection;
use Str;
use Telegram;
use Telegram\Bot\Api;

//use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

//use Telegram;
class TelegramController extends Controller
{
    use Profile;
    use Register;
    use Ads;
    use Start;
    use Methods;
    use Language;
    use Helper;

    //index
    public function index()
    {
        $t = new Api(st()->botApiToken);
        //  $t = new Api('5000545191:AAEQRciGRoWXjw42zwHyqJMUWaQB53WFezw');
        //  return response(' sefsef ');
        $u = $t->getWebhookUpdate();
        $m = $u->getMessage();
        $from = $m?->from;
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
                            case '/start':
                                $this->start($t, $u);

                                break;
                            case 'بازگشت':
                                $this->startRemoveKeyboard($t, $u);

                                break;
                            case 'Return':
                                $this->startRemoveKeyboard($t, $u);

                                break;
                            default:
                                //چک آخرین پاسخ تا مشخص شود پاسخ برای چی هست.
                                //بعد ذخیره سازی
                                switch (auth()->user()->telegram_last_message) {
                                // case 'لطفا نوع حساب کاربری خود را مشخص کنید':
                                // $this->profileRuleStore($t, $u, $m);
                                // break;
                                // case 'لطفا نام جدید خود را ارسال کنید':
                                // $this->profileFirstNameStore($t, $u, $m);
                                // break;
                                // case 'لطفا نام خانوادگی جدید خود را ارسال کنید':
                                // $this->profileLastNameStore($t, $u, $m);
                                // break;
                                // case 'لطفا نام نمایشی جدید خود را ارسال کنید':
                                // $this->profileFullNameStore($t, $u, $m);
                                // break;
                                // case 'لطفا ایمیل جدید خود را ارسال کنید':
                                // $this->profileEmailStore($t, $u, $m);
                                // break;
                                // case 'لطفا آدرس جدید خود را ارسال کنید':
                                // $this->profileAddressStore($t, $u, $m);
                                // break;
                                // case 'لطفا توضیحات جدید خود را ارسال کنید':
                                // $this->profileDescriptionStore($t, $u, $m);
                                // break;
                                // case 'لطفا رمز عبور جدید خود را ارسال کنید':
                                // $this->profilePasswordStore($t, $u, $m);
                                // break;
                                // case 'لطفا عنوان آگهی را ارسال کنید':
                                // $this->adsCreateTitleStore($t, $u, $m);
                                // break;
                                // case 'لطفا متن آگهی را وارد کنید':
                                // // dump('aaaaaaaaaaaaaaaa');
                                // $this->adsCreateContentStore($t, $u, $m);
                                // break;
                                // case 'لطفا قیمت را وارد کنید':
                                // $this->adsCreatePriceStore($t, $u, $m);
                                // break;
                                // case 'لطفا عنوان آگهی را ویرایش کنید.':
                                // $this->adsEditTitleStore($t, $u, $m);
                                // break;
                                // case 'لطفا استان را ویرایش کنید.':
                                // $this->adsEditStateStore($t, $u, $m);
                                // break;
                                // case 'لطفا نام شهر را ویرایش کنید.':
                                // $this->adsEditCityStore($t, $u, $m);
                                // break;
                                // case 'لطفا متن آگهی را ویرایش کنید.':
                                // $this->adsEditContentStore($t, $u, $m);
                                // break;
                                // case 'لطفا قیمت را ویرایش کنید.':
                                // $this->adsEditPriceStore($t, $u, $m);
                                // break;
                                // case 'لطفا عکس را ویرایش کنید.':
                                // $this->adsEditGalleryStore($t, $u, $m);
                                // break;
                                    default:
                                        $id = $this->routeTo($t, $u, $m);
                                        // $this->start($t, $u);
                                }

                                break;
                        }

                        break;
                        /////contact//////////////////////////////////////////
                    case 'contact':
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
                    // case 'لطفا عکس پروفایل خود را ارسال کنید':
                    // $this->profileAvatarStore($t, $u, $m);
                    // break;
                    // case 'لطفا عکس ها را ارسال کنید.':
                    // $this->adsCreateGalleryStore($t, $u, $m);
                    // break;
                    // case 'لطفا عکس های جدید را ارسال کنید.':
                    // $this->adsEditGalleryStore($t, $u, $m);
                    // break;
                            default:
                                $id = $this->routeTo($t, $u, $m);

                                break;
                        }

                        break;
                }

                break;

                //   case 'edited_message':
                ////    return $t->editedMessage;
                //   case 'channel_post':
                ////    return $t->channelPost;
                //   case 'edited_channel_post':
                ////    return $t->editedChannelPost;
                //   case 'inline_query':
                ////    return $t->inlineQuery;
                //   case 'chosen_inline_result':
                ////    return $t->chosenInlineResult;
            case 'callback_query':
                $cq = $u->callbackQuery;
                switch ($cq->data) {
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
                    case 'adsCreateSendAndStore':
                        $this->adsCreateSendAndStore($t, $u, $m);

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
                            case $s->is('adsEdit*') :
                                $this->adsEdit($t, $u, (int)Str::after($d, 'adsEdit'));

                                break;
                            case $s->is('adsCreateStateStore*') :
                                $this->adsCreateStateStore($t, $u, $m, (int)Str::after($d, 'adsCreateStateStore'));

                                break;
                            case $s->is('adsCreateCityStore*') :
                                $this->adsCreateCityStore($t, $u, $m, (int)Str::after($d, 'adsCreateCityStore'));

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
                            case $s->is('adsEditIsFeaturedStore*') :
                                $this->adsEditIsFeaturedStore($t, $u, $m, (int)Str::after($d, 'adsEditIsFeaturedStore'));

                                break;
                            case $s->is('useScoresStore*') :
                                $this->useScoresStore($t, $u, $m, (int)Str::after($d, 'useScoresStore'));

                                break;
                            default:
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
}
