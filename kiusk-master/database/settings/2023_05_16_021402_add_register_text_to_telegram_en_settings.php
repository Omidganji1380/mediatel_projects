<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddRegisterTextToTelegramEnSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->add('startBackText', 'Hello
            Good time
            Welcome to Kiusk.');
            $b->add('startTextMorning', 'Hello
            Good morning
            Welcome to Kiusk.');
            $b->add('startTextAfternoon', 'Hello
            Good afternoon
            Welcome to Kiusk.');
            $b->add('startTextEvening', 'Hello
            Good evening
            Welcome to Kiusk.');
            $b->add('alreadyRegisterText', 'You have already registered on the site!');
            $b->add('helpText', 'Help text ...');
            $b->add('registerNormalUserText', 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->add('registerNormalUserGuideText', 'Normal User help text ...');
            $b->add('registerNormalUserSuccess', 'Register completed successfully.');
            $b->add('registerBusinessOwnerUserText', 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->add('registerBusinessOwnerUserGuideText', 'Business owner help text ...');
            $b->add('registerBusinessOwnerSuccess', 'Register completed successfully.');
            $b->add('registerSellerText', 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->add('registerSellerUserGuideText', 'Seller User help text ...');
            $b->add('registerSellerSuccess', 'Register completed successfully.');
            $b->add('adCreatePreviewText', 'Information has been successfully registered. Use the "Send for confirmation and display" button to save and final registration.');
            $b->add('advertismentText', 'Coming soon ...');
            $b->add('pinAdText', 'Coming soon ...');
        });
    }
}
