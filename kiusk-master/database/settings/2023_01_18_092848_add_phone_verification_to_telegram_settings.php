<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddPhoneVerificationToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('userSubscriptionStatusError', 'آگهی با موفقیت ایجاد شد. آگهی پس از خرید یا ارتقا بسته، تایید و منتشر خواهد شد.');
            $b->add('phoneVerificationRequiredError', 'لطفا ابتدا شماره مبایل خود را تایید کنید.');
            $b->add('createAdVerifyPhoneKeyboard', json_encode([
                                                    [
                                                        'keyName' => 'تایید',
                                                    ],
                                                    [
                                                        'keyName' => 'بازگشت',
                                                    ],
                                                ]));
        });

        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->add('userSubscriptionStatusError', 'Ad successfully created. The ad will be approved and published after purchasing or upgrading the plan.');
            $b->add('phoneVerificationRequiredError', 'Please confirm your mobile number first.');
            $b->add('createAdVerifyPhoneKeyboard', json_encode([
                                                    [
                                                        'keyName' => 'Verify',
                                                    ],
                                                    [
                                                        'keyName' => 'Return',
                                                    ],
                                                ]));
        });
    }
}
