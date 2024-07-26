<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class GeneralReset extends SettingsMigration
{
    public function up(): void
    {
        $uuid1 = (string)Str::uuid();
        //  $footerMenuUrls = [
        ////   'صفحه اصلی' => route('front.home',[],false),
        //   $uuid1 => 'dd',
        //
        //  ];
        $list = $this->getListUrl([
            'صفحه اصلی' => route('front.home', [], false),
            'پیشخوان' => route('front.blog.category.blog.index', [], false),
            //  'اخبار' => route('front.blog.category.news.index.first.page', [], false),
            'درباره ما' => route('front.about-us', [], false),
            'قوانین و مقررات' => route('front.rules', [], false),
        ]);
        $listHeaderMainMenu = $this->getListUrl([
            'صفحه اصلی' => route('front.home', [], false),
            'پیشخوان' => route('front.blog.category.blog.index', [], false),
            //    'اخبار' => route('front.blog.category.news.index.first.page', [], false),
            'تماس با ما' => route('front.contact-us', [], false),
            'قوانین و مقررات' => route('front.rules', [], false),
        ]);
        $this->migrator->inGroup('general', function (SettingsBlueprint $b) use ($list, $listHeaderMainMenu): void {
            $b->update('copyright', fn ($v) => 'Copyright @2023 Kiusk');
            $b->update('favicon', fn ($v) => 'setting/favicon.png');
            $b->update('logo', fn ($v) => 'setting/4611.png');
            $b->update('responseCache', fn ($v) => true);
            $b->update('footerBackgroundImage', fn ($v) => 'setting/footer-background-icons.jpg');
            $b->update('footerDescription', fn ($v) => '<p>
                اولین پلتفرم فارسی کانادا ویژه خرید فروش کالای نو و کارکرده و دایرکتوری بیزنس های ایرانی در کانادا
                در کیوسک می توانید براحتی نیازمندی های فارسی در شهرهای تورنتو، ونکوور، مونترال و سایر شهرهای کانادا را مشاهده کنید.
            </p>');
            $b->update('footerTitleMenu', fn ($v) => 'دسترسی سریع');
            $b->update('footerMenuUrls', fn ($v) => $list);
            $b->update('footerTitleContactUs', fn ($v) => 'تماس با ما');
            $b->update('footerListContactUs', fn ($v) => json_encode([
                [
                    'addressIcon' => "fa fa-envelope",
                    'addressName' => 'ایمیل:',
                    'addressValue' => 'mailto:info@kiusk.ca',
                ],
                [
                    'addressIcon' => "fab fa-instagram",
                    'addressName' => 'صفحه اینستاگرام',
                    'addressValue' => 'https://instagram.com/kiusk.ca',
                ],
                [
                    'addressIcon' => "fab fa-telegram",
                    'addressName' => 'کانال تلگرام',
                    'addressValue' => 'https://t.me/kiuskcanada',
                ],
            ]));
            $b->update('headerBlackMenu', fn ($v) => json_encode([
                [
                    'icon' => "fa fa-bookmark",
                    'text' => 'علاقه‌مندی ها',
                    'url' => route('front.panel.user.favorite.index', [], false),
                ],
            ]));
            $b->update('headerMainMenu', fn ($v) => $listHeaderMainMenu);
            $b->update('sequenceCategoryMenu', fn ($v) => 3);
            $b->update('headerText', fn ($v) => 'کیوسک | نیازمندی های ایرانیان کانادا | آگهی رایگان نیازمندی ها');
            $b->update(
                'headerTextClose',
                fn ($v) => ' کیوسک | ثبت اگهی رایگان بیزینس های ایرانی کانادا | تورنتو | ونکوور | مونترال'
            );
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
   <h1 style="font-size: medium">نیازمندی&zwnj;های ریز و درشت شما در کیوسک</h1>
   <p>در کیوسک به آسانی می&zwnj;توانید نیازمندی&zwnj;هایتان را بر اساس محله دسته&zwnj;بندی کنید و نزدیک&zwnj;ترین&zwnj;ها
    را بیابید.</p>
   <p>&nbsp;</p>
   <h2 style="font-size: medium">برای قرار دادنِ آگهی&zwnj;های خود در کیوسک</h2>
   <p>بر روی «ثبت آگهی رایگان» را انتخاب کنید و آنگاه آگهی&zwnj;تان را بفرستید.</p>
   <p>فراموش نکنید پیش از هر چیز یک آدرس ایمیل و یک شماره تلفن برای ارسال آگهی ضروری است.</p>
   <p>شما می&zwnj;توانید برای کالا یا خدمات&zwnj;تان عکسی نیز انتخاب کنید.</p>
   <p>به این ترتیب میلیون&zwnj;ها کاربران کیوسک به آسانی آگهی&zwnj; شما را خواهند دید و بر اساس محل آگهی شما را راحت&zwnj;تر
    خواهند یافت.</p>
   <p>&nbsp;</p>
   <h2 style="font-size: medium">خرید و فروش بی&zwnj;واسطه</h2>
   <p>در کیوسک کاربران مستقیماً با هم تماس می&zwnj;گیرند و هیچ واسطه&zwnj;ای در این میان وجود ندارد، پس دقت فرمایید که
    در خرید و فروشِ شما <br>کیوسک هیچ دخالتی ندارد و کاربران باید خودشان جنبه&zwnj;های مختلف امنیتی را در نظر بگیرند.
   </p>
  </div>');
            $b->update('pageContactUs', fn ($v) => '<div class="container pt-5">
   <p>لطفا با ما از طریق ایمیل زیر در ارتباط باشید. </p>
   <p>ایمیل: info [at] kiusk.ca </p>
  </div>');
            $b->update('pageRule', fn ($v) => '<div class="container pt-5">
   <div>
    <p><strong>در نظر داشته باشید، به منظور تسهیل و تسریع فرآیند انتشار آگهی‌ها، کیوسک ممکن است در
      مواردی بر اساس قوانین، متن یا عنوان آگهی شما را به طور جزئی تغییر دهد. همچنین کیوسک مجاز است
      هرگونه پیام، آگهی و یا عکسی که به این سایت ارسال می‌کنید یا هر حساب کاربری و اطلاعات دیگری
      که مربوط به شما یا ایجاد شده توسط شما باشد را هر زمان و به هر شکلی که ضروری بداند حذف نماید.
     </strong></p>
    <p><strong>
      در صورتی که گزارش تخلف کاربران نسبت به آگهی بیشتر از 5 مورد باشد، کیوسک به صلاحدید خود ممکن
      است اقدام به حذف آگهی نماید. در دو فرض اخیر کیوسک هیچ‌گونه مسئولیتی در قبال بازپرداخت
      هزینه‌های پرداختی بابت آگهی حذف شده به کاربر ندارد.
     </strong></p>
    <p><strong>
      آگهی‌دهندگان با ثبت آگهی خود در کیوسک تأیید می‌کنند که آگهی ایشان شامل مواردی که در ادامه
      آورده می‌شوند نخواهد بود و همچنین دارای سن بالای ۱۸ سال هستند.
     </strong></p>
    <div>
     <ul class="list-style-type">
      <li>ناقض حریم شخصی افراد،</li>
      <li>آگهی‌های فروشی بدون تصویر در بخش‌های «مربوط به خانه» و «شخصی»،</li>
      <li>درج قیمت در عنوان آگهی،</li>
      <li>هر گونه توهین به ادیان</li>
      <li>استفاده ابزاری از تصاویر اشخاص در آگهی، درج بی‌مورد عکس صورت اشخاص یا استفاده از عکس
       کودکان برای معرفی کالا و خدماتی که مخاطب آن کودکان نیستند،
      </li>
      <li>ابزار یا آموزش‌های نفوذ، خرابکاری، شکستن قفل، هک و کرک،</li>
      <li>فروش برنامه‌های نرم‌افزاری یا کتاب‌هایی که شامل «قانون کپی رایت » می شوند،</li>
      <li>هر گونه کالایی که موجب رواج خشونت و آسیب رساندن به دیگران می‌شود، مانند: سلاح‌های گرم و
       سرد، مواد محترقه و امثال آن،
      </li>
      <li>درج مکرر آگهی‌‌های یکسان حتی با عناوین متفاوت در یک روز،</li>
      <li>ارسال مجدد یک آگهی‌‌ که از زمان حذف آن توسط کاربر، بیش از ۲۴ ساعت سپری نشده باشد.</li>
     </ul>
    </div>
   </div>
  </div>');
            $b->update(
                'PAYPAL_CLIENT_ID',
                fn ($v) => 'AfTF3g1tED5hDzwoKVTbPInHz5MwEOWx_h-Ll0kwOFbiHTijHtzHqPfNLTGxOI2Mmg0YuiUsIW20xg-a'
            );
            $b->update(
                'PAYPAL_SECRET',
                fn ($v) => 'EIN6ERxs2RF57_rR_kq1huFkcUkeegqx5mxkKnW_KxIm0KBIt4WO3JRPeFAfRvLNBwTpJI7RJ8VC13HG'
            );
            $b->update('PAYPAL_MODE', fn ($v) => 'sandbox');
            $b->update('seoMeta', fn ($v) => json_encode([
                'title' => "کیوسک | نیازمندی های ایرانیان کانادا",
                'titleBefore' => false,
                'description' => 'ثبت اگهی رایگان ایرانی در کانادا، لیست نیازمندی های ایرانی در کانادا، تورنتو، مونترال و ونکوور',
                'separator' => ' | ',
                'canonical' => 'current',
                'robots' => 'index, follow',
                'seo_title_max' => 59,
                'seo_title_middle' => 41,
                'seo_description_max' => 141,
                'seo_description_middle' => 106,
            ]));
            $b->update('seoMetaKeywords', fn ($v) => json_encode([
                'کیوسک',
                'نیازمندی ها',
                'کانادا',
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
                'title' => 'کیوسک | آگهی رایگان نیازمندی ها و بیزینس های ایرانی در کانادا',
                'description' => 'ثبت اگهی رایگان ایرانی در کانادا، لیست نیازمندی های ایرانی در کانادا، تورنتو، مونترال و ونکوور',
                'url' => null,
                'type' => 'website',
                'site_name' => 'کیوسک',
                'locale' => 'fa_IR',
            ]));
            $b->update('seoOpengraphImages', fn ($v) => json_encode([]));
            $b->update('seoTwitter', fn ($v) => json_encode([
                'card' => 'summary_large_image',
                'site' => '@',
            ]));
            $b->update('seoJsonLd', fn ($v) => json_encode([
                'title' => 'کیوسک | نیازمندی های ایرانیان کانادا',
                'description' => 'ثبت اگهی رایگان ایرانی در کانادا، لیست نیازمندی های ایرانی در کانادا، تورنتو، مونترال و ونکوور',
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
            $b->update('createdAdNotificationPendingPayment', fn ($v) => 'لطفا اشتراک خود را تمدید یا ارتقا دهید.');

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
