<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class addLanguageToSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('languagePersian', 'فارسی');
            $b->add('languageEnglish', 'انگلیسی');
        });

        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->add('languagePersian', 'Persian');
            $b->add('languageEnglish', 'English');
        });
    }
}
