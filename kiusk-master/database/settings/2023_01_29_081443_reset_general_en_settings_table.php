<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class ResetGeneralEnSettingsTable extends SettingsMigration
{
    public function up(): void
    {
        $list = $this->getListUrl([
            'Home' => route('en.front.home', [], false),
            'Counter' => route('en.front.blog.category.blog.index', [], false),
            // 'News' => route('en.front.blog.category.news.index.first.page', [], false),
            'About Us' => route('en.front.about-us', [], false),
            'Terms and Conditions' => route('en.front.rules', [], false),
        ]);
        $listHeaderMainMenu = $this->getListUrl([
            'Home' => route('en.front.home', [], false),
            'Counter' => route('en.front.blog.category.blog.index', [], false),
            // 'News' => route('en.front.blog.category.news.index.first.page', [], false),
            'Contact Us' => route('en.front.contact-us', [], false),
            'Terms and Conditions' => route('en.front.rules', [], false),
        ]);

        $this->migrator->inGroup('general_en', function (SettingsBlueprint $b) use ($list, $listHeaderMainMenu): void {
            $b->update('copyright', fn ($v) => 'Copyright @2023 Kiusk');
            $b->update('favicon', fn ($v) => 'setting/favicon.png');
            $b->update('logo', fn ($v) => 'setting/4611.png');
            $b->update('responseCache', fn ($v) => true);
            $b->update('footerBackgroundImage', fn ($v) => 'setting/footer-background-icons.jpg');
            $b->update('footerDescription', fn ($v) => "<p>
                Canada's first Persian platform for buying and selling new and used goods and directory of Iranian businesses in Canada
                In the kiusk, you can easily see Persian requirements in Toronto, Vancouver, Montreal and other Canadian cities.
            </p>");
            $b->update('footerTitleMenu', fn ($v) => 'Quick Access');
            $b->update('footerMenuUrls', fn ($v) => $list);
            $b->update('footerTitleContactUs', fn ($v) => 'Contact Us');
            $b->update('footerListContactUs', fn ($v) => json_encode([
                [
                    'addressIcon' => "fa fa-envelope",
                    'addressName' => 'Email:',
                    'addressValue' => 'mailto:info@kiusk.ca',
                ],
                [
                    'addressIcon' => "fab fa-instagram",
                    'addressName' => 'Instagram Account',
                    'addressValue' => 'https://instagram.com/kiusk.ca',
                ],
                [
                    'addressIcon' => "fab fa-telegram",
                    'addressName' => 'Telegram Bot',
                    'addressValue' => 'https://t.me/kiuskcanada',
                ],
            ]));
            $b->update('headerBlackMenu', fn ($v) => json_encode([
                [
                    'icon' => "fa fa-bookmark",
                    'text' => 'Favorites',
                    'url' => route('en.front.panel.user.favorite.index', [], false),
                ],
            ]));
            $b->update('headerMainMenu', fn ($v) => $listHeaderMainMenu);
            $b->update('sequenceCategoryMenu', fn ($v) => 3);
            $b->update('headerText', fn ($v) => 'Kiusk | The requirements of Iranians in Canada | Free Requirements ads');
            $b->update('headerTextClose', fn ($v) => 'Kiusk | Free registration of Iranian Canadian businesses | Toronto | Vancouver | Montreal');
            $b->update('headerBackgroundImage', fn ($v) => 'setting/hero-background-icons (1).jpg');
            $b->update('numberAdsHomePage', fn ($v) => 20);
            $b->update('numberBlogPostsHomePage', fn ($v) => 10);
            $b->update('numberAdsCategoryAdPage', fn ($v) => 16);
            $b->update('numberAdsCityCategoryAdPage', fn ($v) => 16);
            $b->update('numberAdsSearchAdPage', fn ($v) => 16);
            $b->update('numberAdsUserShowAdPage', fn ($v) => 8);
            $b->update('numberAdsSimilarShowAdPage', fn ($v) => 8);
            $b->update('numberPostsBlogPage', fn ($v) => 6);
            $b->update('numberPostsBlogNewsPage', fn ($v) => 6);
            $b->update('numberPostsSidebarIndexBlogPage', fn ($v) => 5);
            $b->update('numberAdsSidebarIndexBlogPage', fn ($v) => 10);
            $b->update('numberPostsSidebarShowBlogPage', fn ($v) => 5);
            $b->update('numberAdsSidebarShowBlogPage', fn ($v) => 10);
            $b->update('numberPostsShowBlogPage', fn ($v) => 6);
            $b->update('pageAboutUs', fn ($v) => '<div class="container">
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
            $b->update('pageContactUs', fn ($v) => '<div class="container pt-5">
                    <p>Please contact us via the email below. </p>
                    <p>Email: info [at] kiusk.ca </p>
                </div>');
            $b->update('pageRule', fn ($v) => '<div class="container pt-5">
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
            $b->update('PAYPAL_CLIENT_ID', fn ($v) => 'AfTF3g1tED5hDzwoKVTbPInHz5MwEOWx_h-Ll0kwOFbiHTijHtzHqPfNLTGxOI2Mmg0YuiUsIW20xg-a');
            $b->update('PAYPAL_SECRET', fn ($v) => 'EIN6ERxs2RF57_rR_kq1huFkcUkeegqx5mxkKnW_KxIm0KBIt4WO3JRPeFAfRvLNBwTpJI7RJ8VC13HG');
            $b->update('PAYPAL_MODE', fn ($v) => 'sandbox');
            $b->update('seoMeta', fn ($v) => json_encode([
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
            $b->update('seoMetaKeywords', fn ($v) => json_encode([
                'Kiusk',
                'requirements',
                'Canada',
            ]));
            $b->update('seoMetaWebmasterTags', fn ($v) => json_encode([
                'google' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                'bing' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                'alexa' => null,
                'pinterest' => null,
                'yandex' => null,
                'norton' => null,
            ]));
            $b->update('seoOpengraph', fn ($v) => json_encode([
                'title' => 'Kiusk | Free advertisement of Iranian needs and businesses in Canada',
                'description' => 'Registration of free Iranian ads in Canada, list of Iranian needs in Canada, Toronto, Montreal and Vancouver',
                'url' => null,
                'type' => 'website',
                'site_name' => 'Kiusk',
                'locale' => 'fa_IR',
            ]));
            $b->update('seoOpengraphImages', fn ($v) => json_encode([]));
            $b->update('seoTwitter', fn ($v) => json_encode([
                'card' => 'summary_large_image',
                'site' => '@',
            ]));
            $b->update('seoJsonLd', fn ($v) => json_encode([
                'title' => 'Kiusk | The needs of Iranians in Canada',
                'description' => 'Registration of free Iranian ads in Canada, list of Iranian needs in Canada, Toronto, Montreal and Vancouver',
                'url' => null,
                'type' => 'WebSite',
            ]));
            $b->update('seoJsonLdImages', fn ($v) => json_encode([]));
            $b->update('allowViewTelescopeUsers', fn ($v) => json_encode([
                [
                    'email' => 'farhad.3.rohani@gmial.com',
                    'name' => 'farhad rohani moghaddas',
                ],
            ]));
            $b->update('telescopeNightMode', fn ($v) => false);
            $b->update('telescopeRecordAll', fn ($v) => false);
            $b->update('welcome_message', fn ($v) => 'Welcome to Kiusk');
            $b->update('created_ad_notification_pending', fn ($v) => 'The ad has been created successfully. It will be published after approval.');
            $b->update('created_ad_notification_pending_payment', fn ($v) => 'Ad successfully created. The ad will be approved and published after purchasing or upgrading the plan.');
            $b->update('payment_notification_message', fn ($v) => 'This is a confirmation that we’ve just received your online payment.');

            $b->update('scoresText', fn ($v) => json_encode([
                'comment' => [
                    'description' => 'description comment',
                    'tilte' => 'tilte comment',
                    'subtilte' => 'subtilte comment',
                    'icon' => 'fa fa-comment-alt-lines fa-5x text-black-50',
                ],
                'review' => [
                    'description' => 'description review',
                    'tilte' => 'tilte review',
                    'subtilte' => 'subtilte review',
                    'icon' => 'fa fa-comment-lines fa-5x text-info',
                ],
                'rate' => [
                    'description' => 'description rate',
                    'tilte' => 'tilte rate',
                    'subtilte' => 'subtilte rate',
                    'icon' => 'fa fa-star fa-5x text-warning',
                ],
                'referral' => [
                    'description' => 'description referral',
                    'tilte' => 'tilte referral',
                    'subtilte' => 'subtilte referral',
                    'icon' => 'fa fa-user-friends fa-5x text-black',
                ],
                'complete_registration' => [
                    'description' => 'description complete_registration',
                    'tilte' => 'tilte complete_registration',
                    'subtilte' => 'subtilte complete_registration',
                    'icon' => 'fa fa-id-card fa-5x text-info',
                ],
                'google_review' => [
                    'description' => 'description google_review',
                    'tilte' => 'tilte google_review',
                    'subtilte' => 'subtilte google_review',
                    'icon' => 'fab fa-google fa-5x text-primary',
                ],
                'send_video' => [
                    'description' => 'description send_video',
                    'tilte' => 'tilte send_video',
                    'subtilte' => 'subtilte send_video',
                    'icon' => 'fa fa-video-plus fa-5x text-success',
                ],
                'service_usage' => [
                    'description' => 'description service_usage',
                    'tilte' => 'tilte service_usage',
                    'subtilte' => 'subtilte service_usage',
                    'icon' => 'fa fa-ballot-check fa-5x text-title',
                ],
            ]));

            $b->update('scores', fn ($v) => json_encode([
                'customer' => [
                    'comment' => 1,
                    'rate' => 1,
                    'referral' => 3,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'business_owner' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'seller' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'real_estate' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ],
                'vip' => [
                    'comment' => 2,
                    'rate' => 2,
                    'referral' => 6,
                    'complete_registration' => 2,
                    'google_review' => 10,
                    'send_video' => 15,
                    'service_usage' => 25,
                ]
            ]));

            $b->update('mainPageCategories', fn ($v) => json_encode([
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
            $b->update('pageKiuskUsers', fn ($v) => '
            <div class="container pt-5">
                <div>
                    <p><strong>Kiusk Users</strong></p>
                </div>
            </div>
            ');
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
