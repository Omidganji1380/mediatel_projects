<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddRealEstateEditToTelegramEnSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->add('realEstateEditKeyboard', json_encode([
                [ //0
                    'keyName' => 'Room',
                    'keyText' => 'How many rooms does the property have?',
                    'keyRule' => 'numeric|min:0|max:9999|numeric',
                ],
                [ //1
                    'keyName' => 'Sale Price',
                    'keyText' => 'What is the sale price of the property?',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //2
                    'keyName' => 'Rent Price',
                    'keyText' => 'What is the rent price of the property?',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //3
                    'keyName' => 'Area',
                    'keyText' => 'What is the area of the property?',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //4
                    'keyName' => 'Area Unit',
                    'keyText' => 'What is the unit of measurement for the area of the property?',
                    'keyRule' => 'in:square_meter,square_feet',
                ],
                [ //5
                    'keyName' => 'Bathroom',
                    'keyText' => 'How many bathrooms does the property have?',
                    'keyRule' => 'numeric|min:0|max:9999',
                ],
                [ //6
                    'keyName' => 'Yearly Tax',
                    'keyText' => 'What is the yearly tax for the property?',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //7
                    'keyName' => 'Keeping Price',
                    'keyText' => 'What is the keeping price for the property?',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //8
                    'keyName' => 'Construction Year',
                    'keyText' => 'In what year was the property constructed?',
                    'keyRule' => 'numeric|min:1800',
                ],
                [ //9
                    'keyName' => 'Availability Date',
                    'keyText' => 'When will the property be available for rent/sale?',
                    'keyRule' => 'date',
                ],
                [ //10
                    'keyName' => 'Main Facility',
                    'keyText' => 'What are the main facilities available in the property?',
                    'keyRule' => '_________',
                ],
                [ //11
                    'keyName' => 'Nearby Facility',
                    'keyText' => 'What are some nearby facilities available around the property?',
                    'keyRule' => '_________',
                ],
                [ //12
                    'keyName' => 'Building Facility',
                    'keyText' => 'What are some facilities available in the building where the property is located?',
                    'keyRule' => '_________',
                ],
                [ //13
                    'keyName' => 'Unit Facility',
                    'keyText' => 'What are some facilities available in the unit where the property is located?',
                    'keyRule' => '_________',
                ],
                [ //14
                    'keyName' => 'Mortgage Price',
                    'keyText' => 'What is the mortgage price for the property?',
                    'keyRule' => 'numeric|min:0|max:9999999999',
                ],
                [ //15
                    'keyName' => 'Floor',
                    'keyText' => 'On which floor is the property located?',
                    'keyRule' => 'numeric|min:-9999|max:9999',
                ],
                [ //16
                    'keyName' => 'Parking',
                    'keyText' => 'What kind of parking is available with the property?',
                    'keyRule' => '_________',
                ],
            ]));
        });
    }
}
