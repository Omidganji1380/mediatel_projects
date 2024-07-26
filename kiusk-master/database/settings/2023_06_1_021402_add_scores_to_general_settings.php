<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddScoresToGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $b): void {
            $b->add('scores', json_encode([
                'customer' => [
                    'comment' => 1,
                    'rate' => 1,
                    'referral' => 3,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'business_owner' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'seller' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'real_estate' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'vip' => [
                    'comment' => 2,
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
            $b->add('scores', json_encode([
                'customer' => [
                    'comment' => 1,
                    'rate' => 1,
                    'referral' => 3,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'business_owner' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'seller' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'real_estate' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'vip' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ]
            ]));
        });

        $this->migrator->inGroup('general', function (SettingsBlueprint $b): void {
            $b->add('scoresText', json_encode([
                'comment' => [
                    'description' => 'description comment',
                    'tilte' => 'tilte comment',
                    'subtilte' => 'subtilte comment',
                    'icon' => 'icon comment',
                ],
                'rate' => [
                    'description' => 'description rate',
                    'tilte' => 'tilte rate',
                    'subtilte' => 'subtilte rate',
                    'icon' => 'icon rate',
                ],
                'referral' => [
                    'description' => 'description referral',
                    'tilte' => 'tilte referral',
                    'subtilte' => 'subtilte referral',
                    'icon' => 'icon referral',
                ],
                'complete_registration' => [
                    'description' => 'description complete_registration',
                    'tilte' => 'tilte complete_registration',
                    'subtilte' => 'subtilte complete_registration',
                    'icon' => 'icon complete_registration',
                ],
                'google_review' => [
                    'description' => 'description google_review',
                    'tilte' => 'tilte google_review',
                    'subtilte' => 'subtilte google_review',
                    'icon' => 'icon google_review',
                ],
                'send_video' => [
                    'description' => 'description send_video',
                    'tilte' => 'tilte send_video',
                    'subtilte' => 'subtilte send_video',
                    'icon' => 'icon send_video',
                ],
                'service_usage' => [
                    'description' => 'description service_usage',
                    'tilte' => 'tilte service_usage',
                    'subtilte' => 'subtilte service_usage',
                    'icon' => 'icon service_usage',
                ],
            ]));
        });
        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b): void {
            $b->add('scoresText', json_encode([
                'comment' => [
                    'description' => 'description comment',
                    'tilte' => 'tilte comment',
                    'subtilte' => 'subtilte comment',
                    'icon' => 'icon comment',
                ],
                'rate' => [
                    'description' => 'description rate',
                    'tilte' => 'tilte rate',
                    'subtilte' => 'subtilte rate',
                    'icon' => 'icon rate',
                ],
                'referral' => [
                    'description' => 'description referral',
                    'tilte' => 'tilte referral',
                    'subtilte' => 'subtilte referral',
                    'icon' => 'icon referral',
                ],
                'complete_registration' => [
                    'description' => 'description complete_registration',
                    'tilte' => 'tilte complete_registration',
                    'subtilte' => 'subtilte complete_registration',
                    'icon' => 'icon complete_registration',
                ],
                'google_review' => [
                    'description' => 'description google_review',
                    'tilte' => 'tilte google_review',
                    'subtilte' => 'subtilte google_review',
                    'icon' => 'icon google_review',
                ],
                'send_video' => [
                    'description' => 'description send_video',
                    'tilte' => 'tilte send_video',
                    'subtilte' => 'subtilte send_video',
                    'icon' => 'icon send_video',
                ],
                'service_usage' => [
                    'description' => 'description service_usage',
                    'tilte' => 'tilte service_usage',
                    'subtilte' => 'subtilte service_usage',
                    'icon' => 'icon service_usage',
                ],
            ]));
        });
    }
}
