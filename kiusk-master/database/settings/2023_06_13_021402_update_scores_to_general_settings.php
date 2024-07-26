<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class UpdateScoresToGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $b): void {
            $b->update('scores', fn ($v) => json_encode([
                'customer' => [
                    'comment' => 1,
                    'review' => 1,
                    'rate' => 1,
                    'referral' => 3,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'business_owner' => [
                    'comment' => 2,
                    'review' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'seller' => [
                    'comment' => 2,
                    'review' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'real_estate' => [
                    'comment' => 2,
                    'review' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'vip' => [
                    'comment' => 2,
                    'review' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ]
            ]));
        });
        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b): void {
            $b->update('scores', fn ($v) => json_encode([
                'customer' => [
                    'comment' => 1,
                    'review' => 1,
                    'rate' => 1,
                    'referral' => 3,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'business_owner' => [
                    'comment' => 2,
                    'review' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'seller' => [
                    'comment' => 2,
                    'review' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'real_estate' => [
                    'comment' => 2,
                    'review' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'vip' => [
                    'comment' => 2,
                    'review' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ]
            ]));
        });
    }
}
