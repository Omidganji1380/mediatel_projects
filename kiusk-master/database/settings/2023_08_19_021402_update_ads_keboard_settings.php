<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class UpdateAdsKeboardSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->update('adsCreateKeyboard', fn ($v) => json_encode([
                [
                    'keyName' => 'دسته بندی',
                    'keyText' => 'لطفا دسته بندی را انتخاب کنید',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'عنوان',
                    'keyText' => 'لطفا عنوان آگهی را به فارسی ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'قیمت $',
                    'keyText' => 'لطفا قیمت را ارسال کنید',
                    'keyRule' => 'numeric',
                ],
                [
                    'keyName' => 'متن فارسی',
                    'keyText' => 'لطفا متن آگهی رابه فارسی وارد کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'عکس ها ',
                    'keyText' => 'لطفا عکس ها را ارسال کنید.',
                    'keyRule' => '10',
                    //4
                ],
                [
                    'keyName' => 'شهر',
                    'keyText' => 'لطفا شهر را انتخاب کنید',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'استان',
                    'keyText' => 'لطفا استان را انتخاب کنید',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'بازگشت',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'ارسال برای تایید و نمایش',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'عنوان انگلیسی',
                    'keyText' => 'لطفا عنوان آگهی را به انگلیسی ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'متن انگلیسی',
                    'keyText' => 'لطفا متن آگهی را به انگلیسی وارد کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'آگهی ویژه',
                    'keyText' => 'لطفا انتخاب کنید که آگهی ویژه باشد یا خیر.',
                    'keyRule' => '__________',
                ],
            ]));
            $b->update('adsEditKeyboard', fn ($v) => json_encode([
                [
                    'keyName' => 'دسته بندی',
                    'keyText' => 'لطفا دسته بندی را انتخاب کنید',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'عنوان',
                    'keyText' => 'لطفا عنوان آگهی را ارسال کنید',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'قیمت $',
                    'keyText' => 'لطفا قیمت را ارسال کنید',
                    'keyRule' => 'numeric',
                ],
                [
                    'keyName' => 'متن',
                    'keyText' => 'لطفا متن آگهی را وارد کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'عکس ها ',
                    'keyText' => 'لطفا عکس های جدید را ارسال کنید.',
                    'keyRule' => '10',
                    //4
                ],
                [
                    'keyName' => 'شهر',
                    'keyText' => 'لطفا شهر را انتخاب کنید',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'استان',
                    'keyText' => 'لطفا استان را انتخاب کنید',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'بازگشت',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'ارسال برای تایید و نمایش',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'حذف کردن(غیر قابل بازگشت)',
                    'keyText' => 'از حذف آگهی مطمئن هستید ؟(قابلیت بازگشت وجود ندارد.)',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'ارتقا',
                    'keyText' => '__________',
                    'keyRule' => '__________',
                ],
                [
                    'keyName' => 'عنوان انگلیسی',
                    'keyText' => 'لطفا عنوان آگهی را به انگلیسی ارسال کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'متن انگلیسی',
                    'keyText' => 'لطفا متن آگهی را به انگلیسی وارد کنید',
                    'keyRule' => 'min:3',
                ],
                [
                    'keyName' => 'آگهی ویژه',
                    'keyText' => 'لطفا انتخاب کنید که آگهی ویژه باشد یا خیر.',
                    'keyRule' => '__________',
                ],
            ]));
        });
    }
}
