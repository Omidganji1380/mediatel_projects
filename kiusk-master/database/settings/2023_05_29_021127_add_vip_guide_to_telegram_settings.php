<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddVipGuideToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('registerVIPUserText', 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->add('registerVIPUserGuideText', 'VIP help text ...');
            $b->add('registerVIPSuccess', 'Register completed successfully.');
        });
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->add('registerVIPUserText', 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->add('registerVIPUserGuideText', 'VIP help text ...');
            $b->add('registerVIPSuccess', 'Register completed successfully.');
        });
    }
}
