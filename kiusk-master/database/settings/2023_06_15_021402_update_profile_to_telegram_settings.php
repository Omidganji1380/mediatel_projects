<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class UpdateProfileToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->update('profileKeyboard', fn ($v) => json_encode([
                [ // 0
                    'keyName' => 'نام نمایشی',
                    'keyText' => 'لطفا نام نمایشی جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [ // 1
                    'keyName' => 'عکس پروفایل',
                    'keyText' => 'لطفا عکس پروفایل خود را ارسال کنید',
                    'keyRule' => '__________',
                ],
                [ // 2
                    'keyName' => 'تغییر رمز عبور',
                    'keyText' => 'لطفا رمز عبور جدید خود را ارسال کنید',
                    'keyRule' => '6',
                ],
                [ // 3
                    'keyName' => 'بازگشت',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [ // 4
                    'keyName' => 'نام',
                    'keyText' => 'لطفا نام جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [ // 5
                    'keyName' => 'نام خانوادگی',
                    'keyText' => 'لطفا نام خانوادگی جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [ // 6
                    'keyName' => 'ایمیل',
                    'keyText' => 'لطفا ایمیل جدید خود را ارسال کنید',
                    'keyRule' => 'email',
                ],
                [ // 7
                    'keyName' => 'آدرس',
                    'keyText' => 'لطفا آدرس جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [ // 8
                    'keyName' => 'توضیحات',
                    'keyText' => 'لطفا توضیحات جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [ // 9
                    'keyName' => 'امتیازات',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [ // 10
                    'keyName' => 'کد ارجاع',
                    'keyText' => 'لطفا کد ارجاع خود را وارد نمایید',
                    'keyRule' => 'required|exists:referrals,referral_code',
                ],
            ]));
        });
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->update('profileKeyboard', fn ($v) => json_encode([
                [ // 0
                    'keyName' => 'Display Name',
                    'keyText' => 'Please submit your new display name',
                    'keyRule' => 'min:3',
                ],
                [ // 1
                    'keyName' => 'Profile Picture',
                    'keyText' => 'Please send your profile picture',
                    'keyRule' => '__________',
                ],
                [ // 2
                    'keyName' => 'Change Password',
                    'keyText' => 'Please send your new password',
                    'keyRule' => '6',
                ],
                [ // 3
                    'keyName' => 'Return',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [ // 4
                    'keyName' => 'Name',
                    'keyText' => 'Please submit your new name',
                    'keyRule' => 'min:3',
                ],
                [ // 5
                    'keyName' => 'Last Name',
                    'keyText' => 'Please submit your new last name',
                    'keyRule' => 'min:3',
                ],
                [ // 6
                    'keyName' => 'Email',
                    'keyText' => 'Please send your new email',
                    'keyRule' => 'email',
                ],
                [ // 7
                    'keyName' => 'Address',
                    'keyText' => 'Please send your new address',
                    'keyRule' => 'min:3',
                ],
                [ // 8
                    'keyName' => 'Description',
                    'keyText' => 'Please submit your new description',
                    'keyRule' => 'min:3',
                ],
                [ // 9
                    'keyName' => 'Scores',
                    'keyText' => '_______',
                    'keyRule' => '_______',
                ],
                [ // 10
                    'keyName' => 'Referral Code',
                    'keyText' => 'Please send your referral code',
                    'keyRule' => 'required|exists:referrals,referral_code',
                ],
            ]));
        });
    }
}
