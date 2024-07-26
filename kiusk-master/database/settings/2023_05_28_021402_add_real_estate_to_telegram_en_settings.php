<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddRealEstateToTelegramEnSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->add('realEstateCreateKeyboard', json_encode([
                [ //0
                    'keyName' => 'room',
                    'keyText' => 'How many rooms does the property have?',
                    'keyRule' => 'min:0|max:9999|numeric',
                ],
                [ //1
                    'keyName' => 'sale_price',
                    'keyText' => 'What is the sale price of the property?',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //2
                    'keyName' => 'rent_price',
                    'keyText' => 'What is the rent price of the property?',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //3
                    'keyName' => 'area',
                    'keyText' => 'What is the area of the property?',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //4
                    'keyName' => 'area_unit',
                    'keyText' => 'What is the unit of measurement for the area of the property?',
                    'keyRule' => 'in:square_meter,square_feet',
                ],
                [ //5
                    'keyName' => 'bathroom',
                    'keyText' => 'How many bathrooms does the property have?',
                    'keyRule' => 'min:0|max:9999',
                ],
                [ //6
                    'keyName' => 'yearly_tax',
                    'keyText' => 'What is the yearly tax for the property?',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //7
                    'keyName' => 'keeping_price',
                    'keyText' => 'What is the keeping price for the property?',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //8
                    'keyName' => 'construction_year',
                    'keyText' => 'In what year was the property constructed?',
                    'keyRule' => 'min:1800',
                ],
                [ //9
                    'keyName' => 'availability_date',
                    'keyText' => 'When will the property be available for rent/sale?',
                    'keyRule' => 'date',
                ],
                [ //10
                    'keyName' => 'main_facility',
                    'keyText' => 'What are the main facilities available in the property?',
                    'keyRule' => '_________',
                ],
                [ //11
                    'keyName' => 'nearby_facility',
                    'keyText' => 'What are some nearby facilities available around the property?',
                    'keyRule' => '_________',
                ],
                [ //12
                    'keyName' => 'building_facility',
                    'keyText' => 'What are some facilities available in the building where the property is located?',
                    'keyRule' => '_________',
                ],
                [ //13
                    'keyName' => 'unit_facility',
                    'keyText' => 'What are some facilities available in the unit where the property is located?',
                    'keyRule' => '_________',
                ],
                [ //14
                    'keyName' => 'mortgage_price',
                    'keyText' => 'What is the mortgage price for the property?',
                    'keyRule' => 'min:0|max:9999999999',
                ],
                [ //15
                    'keyName' => 'floor',
                    'keyText' => 'On which floor is the property located?',
                    'keyRule' => 'min:-9999|max:9999',
                ],
                [ //16
                    'keyName' => 'parking',
                    'keyText' => 'What kind of parking is available with the property?',
                    'keyRule' => '_________',
                ],
            ]));
        });
    }
}
