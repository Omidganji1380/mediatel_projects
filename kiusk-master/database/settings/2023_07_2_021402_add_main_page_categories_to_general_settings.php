<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddMainPageCategoriesToGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $b): void {
            $b->add('mainPageCategories', json_encode([
                ["categories" => 12],
                ["categories" => 74],
                ["categories" => 64],
                ["categories" => 104],
                ["categories" => 112],
                ["categories" => 116],
                ["categories" => 110],
                ["categories" => 408],
                ["categories" => 111],
                ["categories" => 181],
                ["categories" => 118],
                ["categories" => 15],
                ["categories" => 183],
                ["categories" => 26],
                ["categories" => 119],
            ]));
            $b->add('pageKiuskUsers', '
            <div class="container pt-5">
                <div>
                    <p><strong>Kiusk Users</strong></p>
                </div>
            </div>
            ');
        });
        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b): void {
            $b->add('mainPageCategories', json_encode([
                ["categories" => 12],
                ["categories" => 74],
                ["categories" => 64],
                ["categories" => 104],
                ["categories" => 112],
                ["categories" => 116],
                ["categories" => 110],
                ["categories" => 408],
                ["categories" => 111],
                ["categories" => 181],
                ["categories" => 118],
                ["categories" => 15],
                ["categories" => 183],
                ["categories" => 26],
                ["categories" => 119],
            ]));
            $b->add('pageKiuskUsers', '
            <div class="container pt-5">
                <div>
                    <p><strong>Kiusk Users</strong></p>
                </div>
            </div>
            ');
        });
    }
}
