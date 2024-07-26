<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('registerPhoneError', 'متاسفیم!در حال حاضر فقط کاربران کانادا مجاز به ثبت نام هستند.');
            $b->add('languageText', 'لطفا زبان خود را مشخص نمایید');
            $b->add('languageTextSuccess', 'زبان با موفقیت تغییر یافت.');
        });
    }
}
