<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddRealEstateToTelegramSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram', function (SettingsBlueprint $b): void {
            $b->add('realEstateCreateKeyboard', json_encode([
                [ //0
                    'keyName' => 'room',
                    'keyText' => 'ملک چند اتاق دارد؟',
                    'keyRule' => 'min:0|max:9999',
                ],
                [ //1
                    'keyName' => 'sale_price',
                    'keyText' => 'قیمت فروش ملک چقدر است؟',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //2
                    'keyName' => 'rent_price',
                    'keyText' => 'قیمت اجاره ملک چقدر است؟',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //3
                    'keyName' => 'area',
                    'keyText' => 'مساحت ملک چقدر است؟',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //4
                    'keyName' => 'area_unit',
                    'keyText' => "واحد اندازه گیری مساحت ملک چیست؟",
                    'keyRule' => 'in:square_meter,square_feet',
                ],
                [ //5
                    'keyName' => 'bathroom',
                    'keyText' => "این ملک چند حمام دارد؟",
                    'keyRule' => 'min:0|max:9999',
                ],
                [ //6
                    'keyName' => 'yearly_tax',
                    'keyText' => "مالیات سالانه برای ملک چقدر است؟",
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //7
                    'keyName' => 'keeping_price',
                    'keyText' => 'قیمت نگهداری ملک چقدر است؟',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //8
                    'keyName' => 'construction_year',
                    'keyText' => "این ملک در چه سالی ساخته شده است؟",
                    'keyRule' => 'min:1800',
                ],
                [ //9
                    'keyName' => 'availability_date',
                    'keyText' => "چه زمانی ملک برای اجاره/فروش در دسترس خواهد بود؟",
                    'keyRule' => 'date',
                ],
                [ //10
                    'keyName' => 'main_facility',
                    'keyText' => "امکانات اصلی موجود در ملک چیست؟",
                    'keyRule' => '_________',
                ],
                [ //11
                    'keyName' => 'nearby_facility',
                    'keyText' => 'چه امکاناتی در اطراف ملک موجود است؟',
                    'keyRule' => '_________',
                ],
                [ //12
                    'keyName' => 'building_facility',
                    'keyText' => "در ساختمانی که ملک در آن قرار دارد چه امکاناتی وجود دارد؟",
                    'keyRule' => '_________',
                ],
                [ //13
                    'keyName' => 'unit_facility',
                    'keyText' => "در واحدی که ملک در آن قرار دارد چه امکاناتی وجود دارد؟",
                    'keyRule' => '_________',
                ],
                [ //14
                    'keyName' => 'mortgage_price',
                    'keyText' => "قیمت رهن ملک چقدر است؟",
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //15
                    'keyName' => 'floor',
                    'keyText' => 'ملک در کدام طبقه واقع شده است؟',
                    'keyRule' => 'min:-9999|max:9999',
                ],
                [ //16
                    'keyName' => 'parking',
                    'keyText' => 'چه نوع پارکینگی با ملک موجود است؟',
                    'keyRule' => '________',
                ],
            ]));
        });
    }
}
