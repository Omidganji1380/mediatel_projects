<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddChannelToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('telegramChannel', '@Kiuskcanada_bot');
        });
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {

            $b->add('telegramChannel', '@Kiuskcanada_bot');
        });
    }
}
