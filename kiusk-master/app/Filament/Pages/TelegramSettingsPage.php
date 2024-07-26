<?php

namespace App\Filament\Pages;

use App\Settings\TelegramSettings;
use Artisan;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Str;
use Filament\Pages\Actions\ButtonAction;
use Telegram;
use Telegram\Bot\Api;

class TelegramSettingsPage extends SettingsPage
{
    protected static ?string $navigationGroup = 'تنظیمات';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'بخش تلگرام';
    protected static ?string $title = 'بخش تلگرام';
    protected static string $settings = TelegramSettings::class;

    protected function getFormSchema(): array
    {
        return [
            Section::make('اتصال ربات')
                ->schema([
                    Placeholder::make('a')
                        ->label('با جستجو Botfather@ در تلگرام میتوانید api را بدست آورید.'),
                    TextInput::make('botApiToken')
                        ->label('Api ریات')
                        ->helperText('بعد از تغییر ابتدا ذخیره کنید و سپس روی دکمه اتصال ربات کلیک کنید.'),
                    TextInput::make('telegramChannel')
                        ->label('کانال تلگرام')
                        ->helperText('کانال متصل به ربات'),
                ])
                ->collapsed(),
            Section::make('شروع')
                ->schema([
                    FileUpload::make('startImage')
                        ->label(__('setting.startImage'))
                        ->directory('setting/telegram'),
                    Textarea::make('startText')
                        ->label(__('setting.startText')),
                    Textarea::make('startBackText')
                        ->label(__('setting.startBackText')),
                    Textarea::make('startTextMorning')
                        ->label(__('setting.startTextMorning')),
                    Textarea::make('startTextAfternoon')
                        ->label(__('setting.startTextAfternoon')),
                    Textarea::make('startTextEvening')
                        ->label(__('setting.startTextEvening')),
                    Section::make(' کیبورد start')
                        ->schema([
                            Repeater::make('startKeyboard')
                                ->label(__('setting.startKeyboard'))
                                ->schema([
                                    TextInput::make('keyName')
                                        ->label(__('setting.keyName'))
                                        ->required(),
                                ])
                                ->disableItemMovement()
                                ->disableItemCreation()
                                ->disableItemDeletion()
                        ])
                        ->collapsed(),
                ])
                ->collapsed(),
            Section::make(' ثبت نام')
                ->schema([
                    TextInput::make('registerText')
                        ->label(__('setting.registerText')),
                    TextInput::make('registerSuccess')
                        ->label(__('setting.registerSuccess')),
                    TextInput::make('registerNormalUserText')
                        ->label(__('setting.registerText')),
                    TextInput::make('registerNormalUserSuccess')
                        ->label(__('setting.registerSuccess')),
                    Textarea::make('registerNormalUserGuideText')
                        ->label(__('setting.adsAcceptTheRulesText'))
                        ->helperText("
                                \*\*bold\*\*
                                <br>
                                **bold**
                                <br>
                                \*italic\*
                                <br>
                                *italic*
                                <br>
                                \`code\`
                                <br>
                                `code`
                                <br>
                                \`\`\`c++
                                <br>
                                code
                                <br>
                                \`\`\`
                                <br>
                                ```c++
                                code
                                ```
                                <br>
                                A [link](http://example.com).

                                A [link](http://example.com).
                    "),
                    TextInput::make('registerBusinessOwnerUserText')
                        ->label(__('setting.registerBusinessOwnerUserText')),
                    TextInput::make('registerBusinessOwnerSuccess')
                        ->label(__('setting.registerBusinessOwnerSuccess')),
                    Textarea::make('registerBusinessOwnerUserGuideText')
                        ->label(__('setting.registerBusinessOwnerUserGuideText'))
                        ->helperText("
                                        \*\*bold\*\*
                                        <br>
                                        **bold**
                                        <br>
                                        \*italic\*
                                        <br>
                                        *italic*
                                        <br>
                                        \`code\`
                                        <br>
                                        `code`
                                        <br>
                                        \`\`\`c++
                                        <br>
                                        code
                                        <br>
                                        \`\`\`
                                        <br>
                                        ```c++
                                        code
                                        ```
                                        <br>
                                        A [link](http://example.com).

                                        A [link](http://example.com).
                    "),
                    TextInput::make('registerRealEstateUserText')
                        ->label(__('setting.registerRealEstateUserText')),
                    TextInput::make('registerRealEstateSuccess')
                        ->label(__('setting.registerRealEstateSuccess')),
                    Textarea::make('registerRealEstateUserGuideText')
                        ->label(__('setting.registerRealEstateUserGuideText'))
                        ->helperText("
                                        \*\*bold\*\*
                                        <br>
                                        **bold**
                                        <br>
                                        \*italic\*
                                        <br>
                                        *italic*
                                        <br>
                                        \`code\`
                                        <br>
                                        `code`
                                        <br>
                                        \`\`\`c++
                                        <br>
                                        code
                                        <br>
                                        \`\`\`
                                        <br>
                                        ```c++
                                        code
                                        ```
                                        <br>
                                        A [link](http://example.com).

                                        A [link](http://example.com).
                            "),
                    TextInput::make('registerSellerText')
                        ->label(__('setting.registerSellerText')),
                    TextInput::make('registerSellerSuccess')
                        ->label(__('setting.registerSellerSuccess')),
                    Textarea::make('registerSellerUserGuideText')
                        ->label(__('setting.registerSellerUserGuideText'))
                        ->helperText("
                                        \*\*bold\*\*
                                        <br>
                                        **bold**
                                        <br>
                                        \*italic\*
                                        <br>
                                        *italic*
                                        <br>
                                        \`code\`
                                        <br>
                                        `code`
                                        <br>
                                        \`\`\`c++
                                        <br>
                                        code
                                        <br>
                                        \`\`\`
                                        <br>
                                        ```c++
                                        code
                                        ```
                                        <br>
                                        A [link](http://example.com).

                                        A [link](http://example.com).
                    "),
                    TextInput::make('registerVipText')
                        ->label(__('setting.registerVipText')),
                    TextInput::make('registerVipSuccess')
                        ->label(__('setting.registerVipSuccess')),
                    Textarea::make('registerVIPUserGuideText')
                        ->label(__('setting.registerVIPUserGuideText'))
                        ->helperText("
                                        \*\*bold\*\*
                                        <br>
                                        **bold**
                                        <br>
                                        \*italic\*
                                        <br>
                                        *italic*
                                        <br>
                                        \`code\`
                                        <br>
                                        `code`
                                        <br>
                                        \`\`\`c++
                                        <br>
                                        code
                                        <br>
                                        \`\`\`
                                        <br>
                                        ```c++
                                        code
                                        ```
                                        <br>
                                        A [link](http://example.com).

                                        A [link](http://example.com).
                    "),

                    TextInput::make('alreadyRegisterText')
                        ->label(__('setting.alreadyRegisterText')),

                    Section::make(' کیبورد ثبت نام')
                        ->schema([
                            Repeater::make('registerKeyboard')
                                ->label(__('setting.registerKeyboard'))
                                ->schema([
                                    TextInput::make('keyName')
                                        ->label(__('setting.keyName'))
                                        ->required(),
                                ])
                                ->disableItemMovement()
                                ->disableItemCreation()
                                ->disableItemDeletion()
                        ])
                        ->collapsed(),
                ])
                ->collapsed(),
            Section::make('پروفایل')
                ->schema([
                    TextInput::make('profileText')
                        ->label(__('setting.profileText')),
                    Section::make(' کیبورد پروفایل')
                        ->schema([
                            Repeater::make('profileKeyboard')
                                ->label(__('setting.profileKeyboard'))
                                ->schema([
                                    TextInput::make('keyName')
                                        ->label(__('setting.keyName'))
                                        ->required(),
                                    TextInput::make('keyText')
                                        ->label(__('setting.keyText'))
                                        ->required(),
                                    TextInput::make('keyRule')
                                        ->label(__('setting.keyRule'))
                                        ->required(),
                                ])
                                ->helperText('<a href="https://laravel.com/docs/8.x/validation">برای قواعد اعتبارسنجی بیشتر به اینجا مراجعه کنید.</a>')
                                ->disableItemMovement()
                                ->disableItemCreation()
                                ->disableItemDeletion()
                        ])
                        ->collapsed()
                ])
                ->collapsed(),
            Section::make('ایجاد آگهی')
                ->schema([
                    TextInput::make('adsCreateText')
                        ->label(__('setting.adsCreateText')),
                    TextInput::make('adCreatePreviewText')
                        ->label(__('setting.adCreatePreviewText')),
                    Textarea::make('adsCreateSuccess')
                        ->label(__('setting.adsCreateSuccess')),
                    Section::make(' کیبورد ایجاد آگهی')
                        ->schema([
                            Repeater::make('adsCreateKeyboard')
                                ->label(__('setting.adsCreateKeyboard'))
                                ->schema([
                                    TextInput::make('keyName')
                                        ->label(__('setting.keyName'))
                                        ->required(),
                                    TextInput::make('keyText')
                                        ->label(__('setting.keyText'))
                                        ->required(),
                                    TextInput::make('keyRule')
                                        ->label(__('setting.keyRule'))
                                        ->required(),
                                ])
                                ->disableItemMovement()
                                ->disableItemCreation()
                                ->disableItemDeletion()
                        ])
                        ->collapsed()
                ])
                ->collapsed(),
            Section::make('ویرایش آگهی')
                ->schema([
                    TextInput::make('adsEditText')
                        ->label(__('setting.adsEditText')),
                    Textarea::make('adsEditSuccess')
                        ->label(__('setting.adsEditSuccess')),
                    Section::make(' کیبورد ویرایش آگهی')
                        ->schema([
                            Repeater::make('adsEditKeyboard')
                                ->label(__('setting.adsEditKeyboard'))
                                ->schema([
                                    TextInput::make('keyName')
                                        ->label(__('setting.keyName'))
                                        ->required(),
                                    TextInput::make('keyText')
                                        ->label(__('setting.keyText'))
                                        ->required(),
                                    TextInput::make('keyRule')
                                        ->label(__('setting.keyRule'))
                                        ->required(),
                                ])
                                ->disableItemMovement()
                                ->disableItemCreation()
                                ->disableItemDeletion()
                        ])
                        ->collapsed()
                ])
                ->collapsed(),
            Section::make('آگهی‌های من')
                ->schema([
                    TextInput::make('adsListText')
                        ->label(__('setting.adsListText')),
                    TextInput::make('adsListTextEmpty')
                        ->label(__('setting.adsListTextEmpty')),
                    TextInput::make('adsListIsNotVisible')
                        ->label(__('setting.adsListIsNotVisible')),
                    TextInput::make('adsListBack')
                        ->label(__('setting.adsListBack')),
                ])
                ->collapsed(),
            Section::make('قبول قوانین')
                ->schema([
                    TextInput::make('adsAcceptTheRulesKeyName')
                        ->label(__('setting.adsAcceptTheRulesKeyName')),
                    Textarea::make('adsAcceptTheRulesText')
                        ->label(__('setting.adsAcceptTheRulesText'))
                        ->helperText("
\*\*bold\*\*
 <br>
**bold**
<br>
\*italic\*
<br>
*italic*
<br>
\`code\`
<br>
`code`
<br>
\`\`\`c++
<br>
code
<br>
\`\`\`
<br>
```c++
code
```
<br>
A [link](http://example.com).

A [link](http://example.com).
"),
                ])
                ->collapsed(),
            Section::make('راهنما')
                ->schema([
                    //  TextInput::make('adsAcceptTheRulesKeyName')
                    //           ->label(__('setting.adsAcceptTheRulesKeyName')),
                    Textarea::make('helpText')
                        ->label(__('setting.helpText'))
                        ->helperText("
\*\*bold\*\*
<br>
**bold**
<br>
\*italic\*
<br>
*italic*
<br>
\`code\`
<br>
`code`
<br>
\`\`\`c++
<br>
code
<br>
\`\`\`
<br>
```c++
code
```
<br>
A [link](http://example.com).

A [link](http://example.com).
                                        "),
                ])
                ->collapsed(),
        ];
    }

    public static function getSlug(): string
    {
        return static::$slug ?? Str::kebab(class_basename(static::class));
    }

    protected function getBreadcrumbs(): array
    {
        return [
            '/admin/client-side-setting' => 'تنظیمات',
            'بخش تلگرام'
        ];
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('setWebhook')
                ->label('اتصال ربات')
                ->action('setWebhook'),
            ButtonAction::make('refresh')
                ->label('ریست تنظیمات')
                ->color('danger')
                ->icon('heroicon-s-exclamation-circle')
                ->action('refresh')
        ];
    }

    public function setWebhook(): void
    {
        $t = new Api(st()->botApiToken);
        $t->setWebhook(['url' => env('APP_URL') . 'bot']);
        $this->notify('success', 'اتصال برقرار شد.');
    }

    public function refresh()
    {
        Artisan::call("migrate:refresh --path=database/settings/2022_02_24_185717_telegram_settings_migration_reset.php");
        $this->redirect(Self::getSlug());
        $this->notify('success', 'تنظیمات ریست شد.');
    }
}
