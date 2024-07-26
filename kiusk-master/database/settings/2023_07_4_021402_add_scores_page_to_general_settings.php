<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddScoresPageToGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $b): void {
            $b->add('pageScores', '
                <div class="container pt-5">
                    <div>
                        <p><strong>Scores Page</strong></p>
                    </div>
                </div>
            ');
        });
        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b): void {
            $b->add('pageScores', '
                <div class="container pt-5">
                    <div>
                        <p><strong>Scores Page</strong></p>
                    </div>
                </div>
            ');
        });
    }
}
