<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddCreateAdNotificationToGeneralSettingsTable extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $b): void {
            $b->add('createdAdNotificationPendingPayment', 'لطفا اشتراک خود را تمدید یا ارتقا دهید.');

        });

        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b): void {
            $b->add('createdAdNotificationPendingPayment', 'Please renew or upgrade your subscription.');
        });
    }
}
