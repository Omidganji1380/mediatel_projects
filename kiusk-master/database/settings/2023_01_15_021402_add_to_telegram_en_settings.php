<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddToTelegramEnSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->add('registerPhoneError', 'Sorry! Currently only Canadian users are allowed to register.');
            $b->add('languageText', 'Please specify your language');
            $b->add('languageTextSuccess', 'Language changed successfully.');
        });
    }
}
