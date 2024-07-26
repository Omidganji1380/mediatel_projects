<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddScoresToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('useScoreText', 'هنگامی که امتیازات یک کاربر به مقدار مشخصی می رسد، می تواند از امتیازات برای دریافت کوپن استفاده کند. برای دریافت کوپن ها، آنها باید طرح تخفیفی را انتخاب کنند که با امتیازات آنها مطابقت داشته باشد. طرح تخفیف تعیین می کند که آنها چه تعداد کوپن می توانند دریافت کنند و چه مقدار تخفیف می توانند دریافت کنند. این سیستم برای پاداش دادن به کاربران برای وفاداری آنها و تشویق آنها به ادامه استفاده از خدمات طراحی شده است.');
            $b->add('useScoreSuccess', 'امتیازات شما با موفقیت ارسال شد. کد تخفیف شما ایجاد شد.');
            $b->update('profileKeyboard', fn ($v) => json_encode([
                [
                    'keyName' => 'نام نمایشی',
                    'keyText' => 'لطفا نام نمایشی جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'عکس پروفایل',
                    'keyText' => 'لطفا عکس پروفایل خود را ارسال کنید',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'تغییر رمز عبور',
                    'keyText' => 'لطفا رمز عبور جدید خود را ارسال کنید',
                    'keyRule' => '6',
                ],
                [
                    'keyName' => 'بازگشت',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'نام',
                    'keyText' => 'لطفا نام جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'نام خانوادگی',
                    'keyText' => 'لطفا نام خانوادگی جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'ایمیل',
                    'keyText' => 'لطفا ایمیل جدید خود را ارسال کنید',
                    'keyRule' => 'email',
                ],
                [
                    'keyName' => 'آدرس',
                    'keyText' => 'لطفا آدرس جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'توضیحات',
                    'keyText' => 'لطفا توضیحات جدید خود را ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'امتیازات',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
            ]));
        });
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->update('profileKeyboard', fn ($v) => json_encode([
                [
                    'keyName' => 'Display Name',
                    'keyText' => 'Please submit your new display name',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'Profile Picture',
                    'keyText' => 'Please send your profile picture',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'Change Password',
                    'keyText' => 'Please send your new password',
                    'keyRule' => '6',
                ],
                [
                    'keyName' => 'Return',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'Name',
                    'keyText' => 'Please submit your new name',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'Last Name',
                    'keyText' => 'Please submit your new last name',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'Email',
                    'keyText' => 'Please send your new email',
                    'keyRule' => 'email',
                ],
                [
                    'keyName' => 'Address',
                    'keyText' => 'Please send your new address',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'Description',
                    'keyText' => 'Please submit your new description',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'Scores',
                    'keyText' => '_______',
                    'keyRule' => '_______',
                ],
            ]));
            $b->add('useScoreText', 'When a user’s scores reach a specific amount, they can use the scores to get coupons. To get the coupons, they have to select a discount plan that matches their scores. The discount plan will determine how many coupons they can get and how much discount they can receive. This system is designed to reward users for their loyalty and encourage them to continue using the service.');
            $b->add('useScoreSuccess', 'Your scores have been submitted successfully. Your discount code has been generated.');
        });
    }
}
