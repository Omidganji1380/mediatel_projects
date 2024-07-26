<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddAdImageToGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $b): void {
            $b->add('mainPageAdPlaceholder', 'settings/ads-main-fa.jpg');
            $b->add('mainPageAdPlaceholder2', 'settings/ads-main-fa-2.jpg');
        });
        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b): void {
            $b->add('mainPageAdPlaceholder', 'settings/ads-main-en.jpg');
            $b->add('mainPageAdPlaceholder2', 'settings/ads-main-en-2.jpg');
        });
    }
}
