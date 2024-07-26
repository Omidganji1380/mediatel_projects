<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralEnSettings extends SettingsMigration
{
    public function up(): void
    {
        $list = $this->getListUrl([
            'Home' => route('en.front.home', [], false),
            'Blog' => route('en.front.blog.category.blog.index', [], false),
            // 'News' => route('en.front.blog.category.news.index.first.page', [], false),
            'About Us' => route('en.front.about-us', [], false),
            'Terms and Conditions' => route('en.front.rules', [], false),
        ]);
        $listHeaderMainMenu = $this->getListUrl([
            'Home' => route('en.front.home', [], false),
            'Blog' => route('en.front.blog.category.blog.index', [], false),
            // 'News' => route('en.front.blog.category.news.index.first.page', [], false),
            'Contact Us' => route('en.front.contact-us', [], false),
            'Terms and Conditions' => route('en.front.rules', [], false),
        ]);

        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b) use ($list, $listHeaderMainMenu): void {
            $b->add('copyright', '<i class="fa fa-copyright"
              aria-hidden="true"></i> All rights reserved.');
            $b->add('favicon', 'setting/favicon.png');
            $b->add('logo', 'setting/4611.png');
            $b->add('responseCache', true);
            $b->add('footerBackgroundImage', 'setting/footer-background-icons.jpg');
            $b->add('footerDescription', '<p>List of jobs for Iranians living in Canadian cities. Introduction of Iranian business and requirements in Toronto, Montreal, Vancouver and other cities. In the kiusk, you can see the requirements of Iranian businesses in Canada.</p>');
            $b->add('footerTitleMenu', 'Quick Access');
            $b->add('footerMenuUrls', $list);
            $b->add('footerTitleContactUs', 'Contact Us');
            $b->add('footerListContactUs', json_encode([
                [
                    'addressIcon' => "fa fa-envelope",
                    'addressName' => 'Email:',
                    'addressValue' => 'info [at] kiusk.ca',
                ],
                [
                    'addressIcon' => "fab fa-instagram",
                    'addressName' => 'Instagram Account',
                    'addressValue' => 'https://instagram.com/kiusk.ca',
                ],
                [
                    'addressIcon' => "fab fa-telegram",
                    'addressName' => 'Telegram Channel',
                    'addressValue' => 'https://t.me/kiuskcanada',
                ],
            ]));
            $b->add('headerBlackMenu', json_encode([
                [
                    'icon' => "fa fa-bookmark",
                    'text' => 'Favorites',
                    'url' => route('en.front.panel.user.favorite.index', [], false),
                ],
            ]));
            $b->add('headerMainMenu', $listHeaderMainMenu);
            $b->add('sequenceCategoryMenu', 3);
            $b->add('headerText', 'Kiusk | The requirements of Iranians in Canada | Free Requirements ads');
            $b->add('headerTextClose', 'Kiusk | Free registration of Iranian Canadian businesses | Toronto | Vancouver | Montreal');
            $b->add('headerBackgroundImage', 'setting/hero-background-icons (1).jpg');
            $b->add('numberAdsHomePage', 20);
            $b->add('numberBlogPostsHomePage', 10);
            $b->add('numberAdsCategoryAdPage', 16);
            $b->add('numberAdsCityCategoryAdPage', 16);
            $b->add('numberAdsSearchAdPage', 16);
            $b->add('numberAdsUserShowAdPage', 8);
            $b->add('numberAdsSimilarShowAdPage', 8);
            $b->add('numberPostsBlogPage', 6);
            $b->add('numberPostsBlogNewsPage', 6);
            $b->add('numberPostsSidebarIndexBlogPage', 5);
            $b->add('numberAdsSidebarIndexBlogPage', 10);
            $b->add('numberPostsSidebarShowBlogPage', 5);
            $b->add('numberAdsSidebarShowBlogPage', 10);
            $b->add('numberPostsShowBlogPage', 6);
            $b->add('pageAboutUs', '<div class="container">
              <p>&nbsp;</p>
              <h1 style="font-size: medium">Your small and large needs in the kiusk</h1>
              <p>In the Kiusk, you can easily categorize your needs by neighborhood and find the nearest ones.</p>
              <p>&nbsp;</p>
              <h2 style="font-size: medium">To place your ads in the Kiusk</h2>
              <p>Choose "free ad registration" and then send your ad.</p>
              <p>Don\'t forget, first of all, an email address and a phone number are necessary to send an ad.</p>
              <p>You can also choose a photo for your product or service.</p>
              <p>In this way, millions of Kiusk users will easily see your ad and find you more easily based on the location of your ad.</p>
              <p>&nbsp;</p>
              <h2 style="font-size: medium">Buy and sell directly</h2>
              <p>In the Kiusk, users contact each other directly and there is no intermediary in between, so make sure that
                 Kiusk is not involved in your buying and selling, and users should consider various aspects of security themselves.
               </p>
              </div>');
            $b->add('pageContactUs', '<div class="container pt-5">
                    <p>Please contact us via the email below. </p>
                    <p>Email: info [at] kiusk.ca </p>
                </div>');
            $b->add('pageRule', '<div class="container pt-5">
              <div>
                <p><strong>Keep in mind, in order to facilitate and speed up the process of publishing ads, Kiusk may slightly change the text or title of your ad in some cases based on the rules. Kiusk is also allowed to delete any message, advertisement or photo you send to this site or any user account and other information related to you or created by you at any time and in any way it deems necessary.
                </strong></p>
                <p><strong>
                If there are more than 5 violations reported by users regarding the ad, the Kiusk may remove the ad at its discretion. In the last two assumptions, the Kiusk has no responsibility for refunding the user for the costs paid for the deleted ad.
                </strong></p>
                <p><strong>
                    By registering their ad in the Kiusk, advertisers confirm that their ad will not include the following and that they are over 18 years old.
                </strong></p>
                <div>
                <ul class="list-style-type">
                  <li>Violating the privacy of people,</li>
                  <li>Ads for sale without images in the "Home" and "Personal" sections.</li>
                  <li>Include the price in the title of the ad.</li>
                  <li>Any insult to religions</li>
                  <li>Instrumental use of people\'s pictures in the ad, unnecessary inclusion of people\'s face photos or use of children\'s photos to introduce products and services that are not aimed at children.
                  </li>
                  <li>Penetration tools or tutorials, sabotage, lock breaking, hacking and cracking,</li>
                  <li>Selling software programs or books that include "copyright law",</li>
                  <li>Any goods that cause the spread of violence and harm to others, such as: firearms and cold weapons, incendiary materials and the like.
                  </li>
                  <li>Repeated insertion of the same ads even with different titles in one day.</li>
                  <li>Reposting an ad that has not been deleted by the user for more than 24 hours,</li>
                </ul>
                </div>
              </div>
              </div>');
            $b->add('PAYPAL_CLIENT_ID', 'AfTF3g1tED5hDzwoKVTbPInHz5MwEOWx_h-Ll0kwOFbiHTijHtzHqPfNLTGxOI2Mmg0YuiUsIW20xg-a');
            $b->add('PAYPAL_SECRET', 'EIN6ERxs2RF57_rR_kq1huFkcUkeegqx5mxkKnW_KxIm0KBIt4WO3JRPeFAfRvLNBwTpJI7RJ8VC13HG');
            $b->add('PAYPAL_MODE', 'sandbox');
            $b->add('seoMeta', json_encode([
                'title' => "Kiusk | The needs of Iranians in Canada",
                'titleBefore' => false,
                'description' => 'Registration of free Iranian ads in Canada, list of Iranian needs in Canada, Toronto, Montreal and Vancouver',
                'separator' => ' | ',
                'canonical' => 'current',
                'robots' => 'index, follow',
                'seo_title_max' => 59,
                'seo_title_middle' => 41,
                'seo_description_max' => 141,
                'seo_description_middle' => 106,
            ]));
            $b->add('seoMetaKeywords', json_encode([
                'Kiusk',
                'requirements',
                'Canada',
            ]));
            $b->add('seoMetaWebmasterTags', json_encode([
                'google' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                'bing' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                'alexa' => null,
                'pinterest' => null,
                'yandex' => null,
                'norton' => null,
            ]));
            $b->add('seoOpengraph', json_encode([
                'title' => 'Kiusk | Free advertisement of Iranian needs and businesses in Canada',
                'description' => 'Registration of free Iranian ads in Canada, list of Iranian needs in Canada, Toronto, Montreal and Vancouver',
                'url' => null,
                'type' => 'website',
                'site_name' => 'Kiusk',
                'locale' => 'fa_IR',
            ]));
            $b->add('seoOpengraphImages', json_encode([]));
            $b->add('seoTwitter', json_encode([
                'card' => 'summary_large_image',
                'site' => '@',
            ]));
            $b->add('seoJsonLd', json_encode([
                'title' => 'Kiusk | The needs of Iranians in Canada',
                'description' => 'Registration of free Iranian ads in Canada, list of Iranian needs in Canada, Toronto, Montreal and Vancouver',
                'url' => null,
                'type' => 'WebSite',
            ]));
            $b->add('seoJsonLdImages', json_encode([]));
            $b->add('allowViewTelescopeUsers', json_encode([
                [
                    'email' => 'farhad.3.rohani@gmial.com',
                    'name' => 'farhad rohani moghaddas',
                ],
            ]));
            $b->add('telescopeNightMode', false);
            $b->add('telescopeRecordAll', false);
            $b->add('welcome_message', 'Welcome to Kiusk');
            $b->add('created_ad_notification_pending', 'The ad has been created successfully. It will be published after approval.');
            $b->add('created_ad_notification_pending_payment', 'Ad successfully created. The ad will be approved and published after purchasing or upgrading the plan.');
            $b->add('payment_notification_message', 'This is a confirmation that we’ve just received your online payment.');
        });
    }

    protected function getListUrl(array $footerMenuUrls): string|false
    {
        $list = [];
        foreach ($footerMenuUrls as $text => $url) {
            $list[] = [
                'text' => $text,
                'url' => $url,
            ];
        }
        $list = json_encode($list);

        return $list;
    }
}
