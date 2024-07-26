<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class TelegramEnSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('telegram_en', function (SettingsBlueprint $b): void {
            $b->add('botApiToken', '5900652188:AAHpEWGV8p97Wg5a3woJ9opg_cBc1rjR6oo');
            $b->add('startImage', 'setting/telegram/4611.png');
            $b->add('startText', 'Hello
            Good time
            Welcome to Kiusk.');
            $b->add('startBackText', 'Welcome to Kiusk.');
            $b->add('startKeyboard', json_encode([
                                                    ['keyName' => 'Create Ad',],
                                                    ['keyName' => 'Register',],
                                                    ['keyName' => 'My Ads',],
                                                    ['keyName' => 'My profile',],
                                                    ['keyName' => 'Language',],
                                                ]));
            $b->add('registerText', 'Dear user, please register your ad after confirming your mobile number.');
            $b->add('registerSuccess', 'Register completed successfully.');
            $b->add('registerKeyboard', json_encode([
                                                     [
                                                      'keyName' => 'Send phone number',
                                                     ],
                                                     [
                                                      'keyName' => 'Return',
                                                     ],
                                                    ]));
            $b->add('profileText', 'Your profile information :');
            $b->add('profileKeyboard', json_encode([
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
            $b->add('adsCreateText', 'Create a new ad');
            $b->add('adsCreateSuccess', 'Your ad was created successfully. It will be published after approval.
                                    To make your ad more visible, upgrade your ad through the edit option and be seen better.');
            $b->add('adsCreateKeyboard', json_encode([
                                                      [
                                                       'keyName' => 'Category',
                                                       'keyText' => 'Please select a category',
                                                       'keyRule' => '__________',
                                                      ],
                                                      [
                                                       'keyName' => 'Title',
                                                       'keyText' => 'Please send the ad title',
                                                       'keyRule' => 'min:3',
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
            $b->add('adsEditText', 'Edit Ad');
            $b->add('adsEditSuccess', 'The ad has been edited successfully. It will be published on the site after approval.');
            $b->add('adsEditKeyboard', json_encode([
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
            $b->add('adsListText', 'Your ads');
            $b->add('adsListTextEmpty', 'You have not registered any ads yet.');
            $b->add('adsListIsNotVisible', '(not confirmed)');
            $b->add('adsListBack', 'Return');
            $b->add('adsAcceptTheRulesKeyName', "accept the rules");
            $b->add('adsAcceptTheRulesText', 'Ad registration rules
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
