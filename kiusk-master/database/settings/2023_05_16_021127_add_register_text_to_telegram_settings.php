<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddRegisterTextToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('startBackText', 'سلام
            وقت بخیر
            به ربات کیوسک خوش آمدید');
            $b->add('startTextMorning', 'سلام
            صبح بخیر
            به ربات کیوسک خوش آمدید');
            $b->add('startTextAfternoon', 'سلام
            عصر بخیر
            به ربات کیوسک خوش آمدید');
            $b->add('startTextEvening', 'سلام
            شب بخیر
            به ربات کیوسک خوش آمدید');
            $b->add('alreadyRegisterText', 'شما قبلا در سایت ثبت نام کرده اید');
            $b->add('helpText', 'متن راهنما ...');
            $b->add('registerNormalUserText', 'کاربرگرامی\nبرای اینکه بتوانید از خدمات رایگان ربات کیوسک استفاده کنید\nشماره تلفن شما باید شماره کانادا🇨🇦 باشد ، تا اگهی های شما در ربات ثبت و در سایر مدیاهای کیوسک منتشر شود\n\nلطفا شماره تلفن خود را با استفاده از دکمه زیر ارسال کنید.👇');
            $b->add('registerNormalUserGuideText', 'متن راهنما کاربر عادی...');
            $b->add('registerNormalUserSuccess', 'ثبت نام شما با موفقیت انجام شد.');
            $b->add('registerBusinessOwnerUserText', 'کاربرگرامی\nبرای اینکه بتوانید از خدمات رایگان ربات کیوسک استفاده کنید\nشماره تلفن شما باید شماره کانادا🇨🇦 باشد ، تا اگهی های شما در ربات ثبت و در سایر مدیاهای کیوسک منتشر شود\n\nلطفا شماره تلفن خود را با استفاده از دکمه زیر ارسال کنید.👇');
            $b->add('registerBusinessOwnerUserGuideText', 'متن راهنما مالک بیزینس...');
            $b->add('registerBusinessOwnerSuccess', 'ثبت نام شما با موفقیت انجام شد.');
            $b->add('registerRealEstateUserText', 'کاربرگرامی\nبرای اینکه بتوانید از خدمات رایگان ربات کیوسک استفاده کنید\nشماره تلفن شما باید شماره کانادا🇨🇦 باشد ، تا اگهی های شما در ربات ثبت و در سایر مدیاهای کیوسک منتشر شود\n\nلطفا شماره تلفن خود را با استفاده از دکمه زیر ارسال کنید.👇');
            $b->add('registerRealEstateUserGuideText', 'متن راهنما مشاورین املاک...');
            $b->add('registerRealEstateSuccess', 'ثبت نام شما با موفقیت انجام شد.');
            $b->add('registerSellerText', 'کاربرگرامی\nبرای اینکه بتوانید از خدمات رایگان ربات کیوسک استفاده کنید\nشماره تلفن شما باید شماره کانادا🇨🇦 باشد ، تا اگهی های شما در ربات ثبت و در سایر مدیاهای کیوسک منتشر شود\n\nلطفا شماره تلفن خود را با استفاده از دکمه زیر ارسال کنید.👇');
            $b->add('registerSellerUserGuideText', 'متن راهنما فروشنده کالا...');
            $b->add('registerSellerSuccess', 'ثبت نام شما با موفقیت انجام شد.');
            $b->add('registerVIPText', 'کاربرگرامی\nبرای اینکه بتوانید از خدمات رایگان ربات کیوسک استفاده کنید\nشماره تلفن شما باید شماره کانادا🇨🇦 باشد ، تا اگهی های شما در ربات ثبت و در سایر مدیاهای کیوسک منتشر شود\n\nلطفا شماره تلفن خود را با استفاده از دکمه زیر ارسال کنید.👇');
            $b->add('registerVIPUserGuideText', 'متن راهنما فروشنده کالا...');
            $b->add('registerVIPSuccess', 'ثبت نام شما با موفقیت انجام شد.');
            $b->add('adCreatePreviewText', 'اطلاعات با موفقیت ثبت شدند. برای ذخیره و ثبت نهایی از دکمه "ارسال برای تایید و نمایش" استفاده نمایید.');
            $b->add('advertismentText', 'به زودی ...');
            $b->add('pinAdText', 'به زودی ...');
        });
    }
}
