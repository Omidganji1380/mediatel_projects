<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class UpdateTelegramPersianSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->update(
            'telegram.startKeyboard',
            fn($v) =>  json_encode([
                [
                    'keyName' => 'ثبت آگهی',
                ],
                [
                    'keyName' => ' ثبت نام',
                ],
                [
                    'keyName' => 'آگهی های من',
                ],
                [
                    'keyName' => 'پروفایل من',
                ],
                [
                    'keyName' => 'زبان',
                ],
            ])
        );
    }
}
