<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class TelegramEnSettings extends Settings
{
    public string $botApiToken;
    public string $startImage;
    public string $startText;
    public string $startBackText;
    public string $startTextMorning;
    public string $startTextAfternoon;
    public string $startTextEvening;
    public string $alreadyRegisterText;
    public string $helpText;
    public string $registerNormalUserText;
    public string $registerNormalUserGuideText;
    public string $registerNormalUserSuccess;
    public string $registerBusinessOwnerUserText;
    public string $registerBusinessOwnerUserGuideText;
    public string $registerBusinessOwnerSuccess;
    public string $registerRealEstateUserText;
    public string $registerRealEstateUserGuideText;
    public string $registerRealEstateSuccess;
    public string $registerSellerText;
    public string $registerSellerUserGuideText;
    public string $registerSellerSuccess;
    public string $registerVIPUserText;
    public string $registerVIPUserGuideText;
    public string $registerVIPSuccess;
    public string $adCreatePreviewText;
    public string $advertismentText;
    public string $pinAdText;
    public string $languageText;
    public string $languageTextSuccess;
    public string $languagePersian;
    public string $languageEnglish;
    public string $phoneVerificationRequiredError;
    public $createAdVerifyPhoneKeyboard;
    public $startKeyboard;
    public string $registerText;
    public string $registerSuccess;
    public string $registerPhoneError;
    public string $userSubscriptionStatusError;
    public $registerKeyboard;
    public string $profileText;
    public $profileKeyboard;
    public string $adsCreateText;
    public string $adsCreateSuccess;
    public $adsCreateKeyboard;
    public $realEstateCreateKeyboard;
    public $realEstateEditKeyboard;
    public string $adsEditText;
    public string $adsEditSuccess;
    public $adsEditKeyboard;
    public string $adsListText;
    public string $adsListTextEmpty;
    public string $adsListIsNotVisible;
    public string $adsListBack;
    public string $adsAcceptTheRulesKeyName;
    public string $adsAcceptTheRulesText;
    public string $useScoreText;
    public string $useScoreSuccess;
    public string $telegramChannel;

    public static function group(): string
    {
        return 'telegram_en';
    }

    public static function casts(): array
    {
        return [
            'adsEditKeyboard' => JsonArray::class,
            'adsCreateKeyboard' => JsonArray::class,
            'profileKeyboard' => JsonArray::class,
            'registerKeyboard' => JsonArray::class,
            'startKeyboard' => JsonArray::class,
            'createAdVerifyPhoneKeyboard' => JsonArray::class,
            'realEstateCreateKeyboard' => JsonArray::class,
            'realEstateEditKeyboard' => JsonArray::class,
        ];
    }
}
