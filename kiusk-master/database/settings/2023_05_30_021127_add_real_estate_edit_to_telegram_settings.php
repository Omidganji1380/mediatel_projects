<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddRealEstateEditToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('realEstateEditKeyboard', json_encode([
                [ //0
                    'keyName' => 'اتاق ها',
                    'keyText' => 'ملک چند اتاق دارد؟',
                    'keyRule' => 'numeric|min:0|max:9999',
                ],
                [ //1
                    'keyName' => 'قیمت فروش',
                    'keyText' => 'قیمت فروش ملک چقدر است؟',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //2
                    'keyName' => 'قیمت اجاره',
                    'keyText' => 'قیمت اجاره ملک چقدر است؟',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //3
                    'keyName' => 'متراژ',
                    'keyText' => 'مساحت ملک چقدر است؟',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //4
                    'keyName' => 'واحد اندازه گیری',
                    'keyText' => "واحد اندازه گیری مساحت ملک چیست؟",
                    'keyRule' => 'in:square_meter,square_feet',
                ],
                [ //5
                    'keyName' => 'حمام ها',
                    'keyText' => "این ملک چند حمام دارد؟",
                    'keyRule' => 'numeric|min:0|max:9999',
                ],
                [ //6
                    'keyName' => 'مالیات سالانه',
                    'keyText' => "مالیات سالانه برای ملک چقدر است؟",
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //7
                    'keyName' => 'قیمت نگهداری',
                    'keyText' => 'قیمت نگهداری ملک چقدر است؟',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //8
                    'keyName' => 'سال ساخت',
                    'keyText' => "این ملک در چه سالی ساخته شده است؟",
                    'keyRule' => 'numeric|min:1800',
                ],
                [ //9
                    'keyName' => 'زمان دسترسی',
                    'keyText' => "چه زمانی ملک برای اجاره/فروش در دسترس خواهد بود؟",
                    'keyRule' => 'date',
                ],
                [ //10
                    'keyName' => 'امکانات عمومی',
                    'keyText' => "امکانات اصلی موجود در ملک چیست؟",
                    'keyRule' => '_________',
                ],
                [ //11
                    'keyName' => 'امکانات اطراف',
                    'keyText' => 'چه امکاناتی در اطراف ملک موجود است؟',
                    'keyRule' => '_________',
                ],
                [ //12
                    'keyName' => 'امکانات ساختمان',
                    'keyText' => "در ساختمانی که ملک در آن قرار دارد چه امکاناتی وجود دارد؟",
                    'keyRule' => '_________',
                ],
                [ //13
                    'keyName' => 'امکانات واحد',
                    'keyText' => "در واحدی که ملک در آن قرار دارد چه امکاناتی وجود دارد؟",
                    'keyRule' => '_________',
                ],
                [ //14
                    'keyName' => 'رهن',
                    'keyText' => "قیمت رهن ملک چقدر است؟",
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //15
                    'keyName' => 'طبقه',
                    'keyText' => 'ملک در کدام طبقه واقع شده است؟',
                    'keyRule' => 'numeric|min:-9999|max:9999',
                ],
                [ //16
                    'keyName' => 'پارکینگ',
                    'keyText' => 'چه نوع پارکینگی با ملک موجود است؟',
                    'keyRule' => '________',
                ],
            ]));
        });
    }
}
