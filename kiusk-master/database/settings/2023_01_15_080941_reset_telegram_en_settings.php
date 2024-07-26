<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class ResetTelegramEnSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->update('botApiToken', fn ($v) => '5900652188:AAHpEWGV8p97Wg5a3woJ9opg_cBc1rjR6oo');
            $b->update('startImage', fn ($v) => 'setting/telegram/4611.png');
            $b->update('startText', fn ($v) => 'Hello
            Good time
            Welcome to Kiusk.');
            $b->update('startBackText', fn ($v) => 'Welcome to Kiusk.');
            $b->update('startKeyboard', fn ($v) => json_encode([
                                                    ['keyName' => 'Create Ad',],
                                                    ['keyName' => 'Register',],
                                                    ['keyName' => 'My Ads',],
                                                    ['keyName' => 'My profile',],
                                                    ['keyName' => 'Language',],
                                                ]));
            $b->update('registerText', fn ($v) => 'Dear user, please register your ad after confirming your mobile number.');
            $b->update('registerSuccess', fn ($v) => 'Register completed successfully.');
            $b->update('registerKeyboard', fn ($v) => json_encode([
                                                     [
                                                      'keyName' => 'Send phone number',
                                                     ],
                                                     [
                                                      'keyName' => 'Return',
                                                     ],
                                                    ]));
            $b->update('phoneVerificationRequiredError', fn ($v) => 'Please confirm your mobile number first.');
            $b->update('createAdVerifyPhoneKeyboard', fn ($v) => json_encode([
                                                    [
                                                        'keyName' => 'Verify',
                                                    ],
                                                    [
                                                        'keyName' => 'Return',
                                                    ],
                                                ]));
            $b->update('profileText', fn ($v) => 'Your profile information :');
            $b->update('profileKeyboard', fn ($v) => json_encode([
                [
                 'keyName' => 'Display Name',
                 'keyText' => 'Please submit your new display name',
                 'keyRule' => 'min:3',
                ],
                [
                 'keyName' => 'Profile Picture',
                 'keyText' => 'Please send your profile picture',
                 'keyRule' => '__________',
                ],
                [
                 'keyName' => 'Change Password',
                 'keyText' => 'Please send your new password',
                 'keyRule' => '6',
                ],
                [
                 'keyName' => 'Return',
                 'keyText' => '__________',
                 'keyRule' => '__________',
                ],
                [
                 'keyName' => 'Name',
                 'keyText' => 'Please submit your new name',
                 'keyRule' => 'min:3',
                ],
                [
                 'keyName' => 'Last Name',
                 'keyText' => 'Please submit your new last name',
                 'keyRule' => 'min:3',
                ],
                [
                 'keyName' => 'Email',
                 'keyText' => 'Please send your new email',
                 'keyRule' => 'email',
                ],
                [
                 'keyName' => 'Address',
                 'keyText' => 'Please send your new address',
                 'keyRule' => 'min:3',
                ],
                [
                 'keyName' => 'Description',
                 'keyText' => 'Please submit your new description',
                 'keyRule' => 'min:3',
                ],
               ]));
            $b->update('adsCreateText', fn ($v) => 'Create a new ad');
            $b->update('adsCreateSuccess', fn ($v) => 'Your ad was created successfully. It will be published after approval.
                                    To make your ad more visible, upgrade your ad through the edit option and be seen better.');
            $b->update('adsCreateKeyboard', fn ($v) => json_encode([
                                                      [
                                                       'keyName' => 'Category',
                                                       'keyText' => 'Please select a category',
                                                       'keyRule' => '__________',
                                                      ],
                                                      [
                                                       'keyName' => 'Persian Title',
                                                       'keyText' => 'Please send the ad title in Farsi',
                                                       'keyRule' => 'min:3',
                                                      ],
                                                      [
                                                       'keyName' => 'Price $',
                                                       'keyText' => 'Please send the price',
                                                       'keyRule' => 'numeric',
                                                      ],
                                                      [
                                                       'keyName' => 'Persian Content',
                                                       'keyText' => 'Please enter the ad content in Farsi',
                                                       'keyRule' => 'min:3',
                                                      ],
                                                      [
                                                       'keyName' => 'Images',
                                                       'keyText' => 'Please send the images.',
                                                       'keyRule' => '10',
                                                       //4
                                                      ],
                                                      [
                                                       'keyName' => 'city',
                                                       'keyText' => 'Please select a city',
                                                       'keyRule' => '__________',
                                                      ],
                                                      [
                                                       'keyName' => 'State',
                                                       'keyText' => 'Please select the state',
                                                       'keyRule' => '__________',
                                                      ],
                                                      [
                                                       'keyName' => 'Return',
                                                       'keyText' => '__________',
                                                       'keyRule' => '__________',
                                                      ],
                                                      [
                                                       'keyName' => 'Submit for approval and display',
                                                       'keyText' => '__________',
                                                       'keyRule' => '__________',
                                                      ],
                                                      [
                                                        'keyName' => 'English Title',
                                                        'keyText' => 'Please send the ad title in English',
                                                        'keyRule' => 'min:3',
                                                       ],
                                                       [
                                                        'keyName' => 'English Content',
                                                        'keyText' => 'Please enter the ad content in English',
                                                        'keyRule' => 'min:3',
                                                       ],
                                                       [
                                                        'keyName' => 'Special Ad',
                                                        'keyText' => 'Please choose that your ad to be special or not',
                                                        'keyRule' => '__________',
                                                       ],
                                                     ]));
            $b->update('adsEditText', fn ($v) => 'Edit Ad');
            $b->update('adsEditSuccess', fn ($v) => 'The ad has been edited successfully. It will be published on the site after approval.');
            $b->update('adsEditKeyboard', fn ($v) => json_encode([
                                                    [
                                                        'keyName' => 'Category',
                                                        'keyText' => 'Please select a category',
                                                        'keyRule' => '__________',
                                                    ],
                                                    [
                                                        'keyName' => 'Title',
                                                        'keyText' => 'Please send the ad title',
                                                        'keyRule' => '__________',
                                                    ],
                                                    [
                                                        'keyName' => 'Price $',
                                                        'keyText' => 'Please send the price',
                                                        'keyRule' => 'numeric',
                                                    ],
                                                    [
                                                        'keyName' => 'Content',
                                                        'keyText' => 'Please enter the ad content',
                                                        'keyRule' => 'min:3',
                                                    ],
                                                    [
                                                        'keyName' => 'Images',
                                                        'keyText' => 'Please send the images.',
                                                        'keyRule' => '10',
                                                     //4
                                                    ],
                                                    [
                                                        'keyName' => 'city',
                                                        'keyText' => 'Please select a city',
                                                        'keyRule' => '__________',
                                                    ],
                                                    [
                                                        'keyName' => 'State',
                                                        'keyText' => 'Please select the state',
                                                        'keyRule' => '__________',
                                                    ],
                                                    [
                                                     'keyName' => 'Return',
                                                     'keyText' => '__________',
                                                     'keyRule' => '__________',
                                                    ],
                                                    [
                                                     'keyName' => 'Send for approval and display',
                                                     'keyText' => '__________',
                                                     'keyRule' => '__________',
                                                    ],
                                                    [
                                                     'keyName' => 'Delete(permanently)',
                                                     'keyText' => 'Are you sure you want to delete the information?(There is no return option.)',
                                                     'keyRule' => '__________',
                                                    ],
                                                    [
                                                     'keyName' => 'Promote',
                                                     'keyText' => '__________',
                                                     'keyRule' => '__________',
                                                    ],
                                                    // 11
                                                    [
                                                        'keyName' => 'English Title',
                                                        'keyText' => 'Please send the ad title in English',
                                                        'keyRule' => 'min:3',
                                                    ],
                                                    [
                                                        'keyName' => 'English Content',
                                                        'keyText' => 'Please enter the ad content in English',
                                                        'keyRule' => 'min:3',
                                                    ],
                                                    [
                                                        'keyName' => 'Special Ad',
                                                        'keyText' => 'Please choose that your ad to be special or not',
                                                        'keyRule' => '__________',
                                                    ],
                                                ]));
            $b->update('adsListText', fn ($v) => 'Your ads');
            $b->update('adsListTextEmpty', fn ($v) => 'You have not registered any ads yet.');
            $b->update('adsListIsNotVisible', fn ($v) => '(not confirmed)');
            $b->update('adsListBack', fn ($v) => 'Return');
            $b->update('registerPhoneError', fn ($v) => 'Sorry! Currently only Canadian users are allowed to register.');
            $b->update('userSubscriptionStatusError', fn ($v) => 'Ad successfully created. The ad will be approved and published after purchasing or upgrading the plan.');
            $b->update('languageText', fn ($v) => 'Please specify your language');
            $b->update('languageTextSuccess', fn ($v) => 'Language changed successfully.');
            $b->update('languagePersian', fn ($v) => 'Persian');
            $b->update('languageEnglish', fn ($v) => 'English');

            $b->update('startBackText', fn ($v) => 'Hello
            Good time
            Welcome to Kiusk.');
            $b->update('startTextMorning', fn ($v) => 'Hello
            Good morning
            Welcome to Kiusk.');
            $b->update('startTextAfternoon', fn ($v) => 'Hello
            Good afternoon
            Welcome to Kiusk.');
            $b->update('startTextEvening', fn ($v) => 'Hello
            Good evening
            Welcome to Kiusk.');
            $b->update('alreadyRegisterText', fn ($v) => 'You have already registered on the site!');
            $b->update('helpText', fn ($v) => 'Help text ...');
            $b->update('registerNormalUserText', fn ($v) => 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->update('registerNormalUserGuideText', fn ($v) => 'Normal User help text ...');
            $b->update('registerNormalUserSuccess', fn ($v) => 'Register completed successfully.');
            $b->update('registerBusinessOwnerUserText', fn ($v) => 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->update('registerBusinessOwnerUserGuideText', fn ($v) => 'Business owner help text ...');
            $b->update('registerBusinessOwnerSuccess', fn ($v) => 'Register completed successfully.');
            $b->update('registerRealEstateUserText', fn ($v) => 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->update('registerRealEstateUserGuideText', fn ($v) => 'Business owner help text ...');
            $b->update('registerRealEstateSuccess', fn ($v) => 'Register completed successfully.');
            $b->update('registerSellerText', fn ($v) => 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->update('registerSellerUserGuideText', fn ($v) => 'Seller User help text ...');
            $b->update('registerSellerSuccess', fn ($v) => 'Register completed successfully.');
            $b->update('registerVIPText', fn ($v) => 'Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇');
            $b->update('registerVIPUserGuideText', fn ($v) => 'VIP User help text ...');
            $b->update('registerVIPSuccess', fn ($v) => 'Register completed successfully.');
            $b->update('adCreatePreviewText', fn ($v) => 'Information has been successfully registered. Use the "Send for confirmation and display" button to save and final registration.');
            $b->update('advertismentText', fn ($v) => 'Coming soon ...');
            $b->update('pinAdText', fn ($v) => 'Coming soon ...');

            $b->update('realEstateEditKeyboard', fn ($v) => json_encode([
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

            $b->update('telegramChannel', fn ($v) => '@Kiuskcanada_bot');

            $b->update('adsAcceptTheRulesKeyName', fn ($v) => "accept the rules");
            $b->update('adsAcceptTheRulesText', fn ($v) => 'Ad registration rules
                    If an ad removal order has been issued by the competent legal authority, Kiusk.ca will remove the ad immediately. Also, if there are more than 5 violations reported by users regarding the ad, Kiusk.ca (Kiusk Group Ltd) may remove the ad at its discretion. In the last two assumptions, Kiusk.ca (Kiusk Group Ltd) has no responsibility for Ads are not deleted to users.

                    By registering their ad on Kiusk.ca (Kiusk Group Ltd), advertisers confirm that their ad will not include the following and that they are over 18 years of age.

                    ✔️ Contradiction with the country of Canada and the custom of the society,
                    ✔️ Any content included in the list of examples of criminal content,
                    Violating people\'s privacy,
                    ✔️ Using phrases or words unrelated to the ad.
                    ✔️ Include the price in the ad title.
                    ✔️ Advertisements without images on the entire site.


                    Any insult to different religions, customs, ethnicities, accents and dialects.

                    Contains text unrelated to the property advertisement.

                    ✅ Instrumental use of people\'s pictures in the ad, unnecessary inclusion of people\'s face photos

                    Any type of political, social or religious advertisement and news distribution that does not have a commercial aspect,

                    ✅ Insert account number or bank account in the text of the ad.

                    ✅ Services and goods suspected of fraud.

                    Repeated insertion of the same ads even with different titles in one day.

                    Re-posting an ad that has not been deleted by the user for more than 24 hours.

                    ✅ Any social networks such as Telegram or Instagram in the description section

                    ✅ Insert SMS system in the text of the ad.

                    ✅ The existence of incorrect sentences in terms of spelling or writing in the text of the advertisement or the title of the advertisement.

                    Any incomprehensible, false or misleading advertisement

                    ✅ Any ad that causes problems with the server or coding of the site for any reason.

                    ✅ Any ad whose title is not Farsi.

                    ✅ Any ad that is included in the wrong category

                    ✅ Any ad related to outside of Canada.

                    ✅ Any ad with email addresses and different accounts.

                    ✅ Any ad that contains keywords that are not related to the ad.

                    ✅ Any ad whose ownership, sale, purchase is illegal.

                    ✅ Repeated posting of the same ads in several different categories.

                    ✅ Inserting an ad that directs site traffic to another address.

                    Any misuse of mobile phone number or e-mail address of others is prosecuted and the advertiser is considered responsible and Kiusk.ca has no responsibility in this case.

                    Your account in order to use the Kiusk.ca (Kiusk group ltd) website, you may need to have an account and register with an email address and password, the email address provided is your email address, and you are personally responsible for maintaining and maintaining your personal password. And you have all the activities of your account, so you should take the utmost care of your password and choose a password that cannot be guessed.
                    You may be connected to a service by a third-party service that allows us to access, save, or use that service, by the permission you have given to that service.

                    If you think your account has been compromised or misused, contact us via email at info@Kiusk.ca.');
        });
    }
}
