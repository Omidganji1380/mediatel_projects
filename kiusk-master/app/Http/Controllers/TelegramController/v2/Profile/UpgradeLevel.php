<?php

namespace App\Http\Controllers\TelegramController\v2\Profile;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait UpgradeLevel
{
    public function profileUpgradeLevelRequest(Api $t, Update $u) : void
    {
        $this->setLanguage();
        $this->deleteLastRequest($t, $u);
        $text = __('messages.telegram.upgrade_level_text');
        $text .= $this->flashMassage();
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => $this->profileUpgradeLevelKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function profileUpgradeLevelKeyboard() : Keyboard
    {
        $inlineButtonUpgradeLevel1 = Keyboard::inlineButton([
            'text' => __('Normal User'),
            'callback_data' => 'profileUpgradeToCustomerStore',
        ]);
        $inlineButtonUpgradeLevel2 = Keyboard::inlineButton([
            'text' => __('Seller'),
            'callback_data' => 'profileUpgradeToSellerStore',
        ]);
        $inlineButtonUpgradeLevel3 = Keyboard::inlineButton([
            'text' => __('Real Estate'),
            'callback_data' => 'profileUpgradeToRealEstateStore',
        ]);
        $inlineButtonUpgradeLevel4 = Keyboard::inlineButton([
            'text' => __('Business Owner'),
            'callback_data' => 'profileUpgradeToBusinessOwnerStore',
        ]);
        $inlineButtonUpgradeLevel5 = Keyboard::inlineButton([
            'text' => __('VIP'),
            'callback_data' => 'profileUpgradeToVipStore',
        ]);
        $inlineButtonUpgradeLevel6 = Keyboard::inlineButton([
            'text' => __('Property Applicant'),
            'callback_data' => 'profileUpgradeToPropertyApplicantStore',
        ]);
        $return = Keyboard::inlineButton([
            'text' => __('Return'),
            'callback_data' => 'profile',
        ]);

        return Keyboard::make()
            ->inline()
            ->row($inlineButtonUpgradeLevel1)
            ->row($inlineButtonUpgradeLevel2)
            ->row($inlineButtonUpgradeLevel3)
            ->row($inlineButtonUpgradeLevel4)
            ->row($inlineButtonUpgradeLevel6)
            ->row($inlineButtonUpgradeLevel5)
            ->row($return);
    }

    public function profileUpgradeToCustomerStore(Api $t, Update $u) : void
    {
        $this->setLanguage();
        if(!$this->checkUserRole('customer')){
            $this->errorMessage(__('messages.profile.upgrade_error'));
            $this->profileUpgradeLevelRequest($t, $u);
        }else{
            auth()->user()->syncRoles('customer');
            $message = __('messages.telegram.success.normal_user');
            $this->successMessage($message);
            $this->profile($t, $u);
        }
    }

    public function profileUpgradeToSellerStore(Api $t, Update $u) : void
    {
        $this->setLanguage();
        if(!$this->checkUserRole('seller')){
            $this->errorMessage(__('messages.profile.upgrade_error'));
            $this->profileUpgradeLevelRequest($t, $u);
        }else{
            auth()->user()->syncRoles('seller');
            $message = __('messages.telegram.success.seller');
            $this->successMessage($message);
            $this->profile($t, $u);
        }
    }

    public function profileUpgradeToBusinessOwnerStore(Api $t, Update $u) : void
    {
        $this->setLanguage();
        if(!$this->checkUserRole('business_owner')){
            $this->errorMessage(__('messages.profile.upgrade_error'));
            $this->profileUpgradeLevelRequest($t, $u);
        }else{
            auth()->user()->syncRoles('business_owner');
            $message = __('messages.telegram.success.business_owner');
            $this->successMessage($message);
            $this->profile($t, $u);
        }
    }

    public function profileUpgradeToRealEstateStore(Api $t, Update $u) : void
    {
        $this->setLanguage();
        if(!$this->checkUserRole('real_estate')){
            $this->errorMessage(__('messages.profile.upgrade_error'));
            $this->profileUpgradeLevelRequest($t, $u);
        }else{
            auth()->user()->syncRoles('real_estate');
            $message = __('messages.telegram.success.real_estate');
            $this->successMessage($message);
            $this->profile($t, $u);
        }
    }

    public function profileUpgradeToPropertyApplicantStore(Api $t, Update $u) : void
    {
        $this->setLanguage();
        if(!$this->checkUserRole('property_applicant')){
            $this->errorMessage(__('messages.profile.upgrade_error'));
            $this->profileUpgradeLevelRequest($t, $u);
        }else{
            auth()->user()->syncRoles('property_applicant');
            $message = __('messages.telegram.success.property_applicant');
            $this->successMessage($message);
            $this->profile($t, $u);
        }
    }

    public function profileUpgradeToVipStore(Api $t, Update $u) : void
    {
        $this->setLanguage();
        $b_1 = Keyboard::inlineButton([
            'text' => __('Vip Plans'),
            'url' => route('front.panel.user.plans.vip')
        ]);
        $b_2 = Keyboard::inlineButton([
            'text' => __('Return'),
            'callback_data' => 'profile',
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($b_1)
            ->row($b_2);
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => __('messages.telegram.vip_plan_purchase'),
            'reply_markup' => $keyboard,
        ]);
    }
}
