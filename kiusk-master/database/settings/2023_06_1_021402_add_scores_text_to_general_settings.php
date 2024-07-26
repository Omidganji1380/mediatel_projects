<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddScoresTextToGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $b): void {
            $b->add('scoresText', json_encode([
                'comment' => [
                    'description' => 'description comment',
                    'tilte' => 'tilte comment',
                    'subtilte' => 'subtilte comment',
                    'icon' => 'fa fa-comment-alt-lines fa-5x text-black-50',
                ],
                'rate' => [
                    'description' => 'description rate',
                    'tilte' => 'tilte rate',
                    'subtilte' => 'subtilte rate',
                    'icon' => 'fa fa-star fa-5x text-warning',
                ],
                'referral' => [
                    'description' => 'description referral',
                    'tilte' => 'tilte referral',
                    'subtilte' => 'subtilte referral',
                    'icon' => 'fa fa-user-friends fa-5x text-black',
                ],
                'complete_registration' => [
                    'description' => 'description complete_registration',
                    'tilte' => 'tilte complete_registration',
                    'subtilte' => 'subtilte complete_registration',
                    'icon' => 'fa fa-id-card fa-5x text-info',
                ],
                'google_review' => [
                    'description' => 'description google_review',
                    'tilte' => 'tilte google_review',
                    'subtilte' => 'subtilte google_review',
                    'icon' => 'fab fa-google fa-5x text-primary',
                ],
                'send_video' => [
                    'description' => 'description send_video',
                    'tilte' => 'tilte send_video',
                    'subtilte' => 'subtilte send_video',
                    'icon' => 'fa fa-video-plus fa-5x text-success',
                ],
                'service_usage' => [
                    'description' => 'description service_usage',
                    'tilte' => 'tilte service_usage',
                    'subtilte' => 'subtilte service_usage',
                    'icon' => 'fa fa-ballot-check fa-5x text-title',
                ],
            ]));
        });
        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b): void {
            $b->add('scoresText', json_encode([
                'comment' => [
                    'description' => 'description comment',
                    'tilte' => 'tilte comment',
                    'subtilte' => 'subtilte comment',
                    'icon' => 'fa fa-comment-alt-lines fa-5x text-black-50',
                ],
                'rate' => [
                    'description' => 'description rate',
                    'tilte' => 'tilte rate',
                    'subtilte' => 'subtilte rate',
                    'icon' => 'fa fa-star fa-5x text-warning',
                ],
                'referral' => [
                    'description' => 'description referral',
                    'tilte' => 'tilte referral',
                    'subtilte' => 'subtilte referral',
                    'icon' => 'fa fa-user-friends fa-5x text-black',
                ],
                'complete_registration' => [
                    'description' => 'description complete_registration',
                    'tilte' => 'tilte complete_registration',
                    'subtilte' => 'subtilte complete_registration',
                    'icon' => 'fa fa-id-card fa-5x text-info',
                ],
                'google_review' => [
                    'description' => 'description google_review',
                    'tilte' => 'tilte google_review',
                    'subtilte' => 'subtilte google_review',
                    'icon' => 'fab fa-google fa-5x text-primary',
                ],
                'send_video' => [
                    'description' => 'description send_video',
                    'tilte' => 'tilte send_video',
                    'subtilte' => 'subtilte send_video',
                    'icon' => 'fa fa-video-plus fa-5x text-success',
                ],
                'service_usage' => [
                    'description' => 'description service_usage',
                    'tilte' => 'tilte service_usage',
                    'subtilte' => 'subtilte service_usage',
                    'icon' => 'fa fa-ballot-check fa-5x text-title',
                ],
            ]));
        });
    }
}
