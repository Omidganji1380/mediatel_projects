<?php

use Illuminate\Support\Str;
use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class general extends SettingsMigration
{
    public function up(): void
    {
        $uuid1 = (string)Str::uuid();
        //  $footerMenuUrls = [
        ////   'صفحه اصلی' => route('front.home',[],false),
        //   $uuid1 => 'dd',
        //  ];
        $list = $this->getListUrl([
                                   'صفحه اصلی' => route('front.home', [], false),
                                   'وبلاگ' => route('front.blog.category.blog.index', [], false),
                                   'اخبار' => route('front.blog.category.news.index.first.page', [], false),
                                   'درباره ما' => route('front.about-us', [], false),
                                   'قوانین و مقررات' => route('front.rules', [], false),
                                  ]);
        $listHeaderMainMenu = $this->getListUrl([
                                                 'صفحه اصلی' => route('front.home', [], false),
                                                 'وبلاگ' => route('front.blog.category.blog.index', [], false),
                                                 'اخبار' => route('front.blog.category.news.index.first.page', [], false),
                                                 'تماس با ما' => route('front.contact-us', [], false),
                                                 'قوانین و مقررات' => route('front.rules', [], false),
                                                ]);
                                                ;
        $this->migrator->inGroup('general', function (SettingsBlueprint $b) use ($list, $listHeaderMainMenu): void {
            $b->add('copyright', '<i class="fa fa-copyright"
              aria-hidden="true"></i> تمام حقوق محفوظ می باشد.');
            $b->add('favicon', 'setting/favicon.png');
            $b->add('logo', 'setting/4611.png');
            $b->add('responseCache', true);
            $b->add('footerBackgroundImage', 'setting/footer-background-icons.jpg');
            $b->add('footerDescription', '<p>
              لیست شغل های ایرانیان مقیم در شهرهای کانادا. معرفی بیزینس و نیازمندی های ایرانی در
              تورنتو،مونترال و ونکوور و سایر شهرها.در کیوسک میتوانید نیازمندی های مشاغل ایرانی موجود در
              کانادا را مشاهده کنید. </p>');
            $b->add('footerTitleMenu', 'دسترسی سریع');
            $b->add('footerMenuUrls', $list);
            $b->add('footerTitleContactUs', 'تماس با ما');
            $b->add('footerListContactUs', json_encode([
                                                        [
                                                         'addressIcon' => "fa fa-envelope",
                                                         'addressName' => 'ایمیل:',
                                                         'addressValue' => 'info [at] kiusk.ca',
                                                        ],
                                                       ]));
            $b->add('headerBlackMenu', json_encode([
                                                    [
                                                     'icon' => "fa fa-bookmark",
                                                     'text' => 'علاقه‌مندی ها',
                                                     'url' => route('front.panel.user.favorite.index', [], false),
                                                    ],
                                                   ]));
            $b->add('headerMainMenu', $listHeaderMainMenu);
            $b->add('sequenceCategoryMenu', 3);
            $b->add('headerText', 'کیوسک | نیازمندی های ایرانیان کانادا | آگهی رایگان نیازمندی ها');
            $b->add('headerTextClose', ' کیوسک | ثبت اگهی رایگان بیزینس های ایرانی کانادا | تورنتو | ونکوور | مونترال');
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
                        $b->add('pageContactUs', '<div class="container pt-5">
              <p>لطفا با ما از طریق ایمیل زیر در ارتباط باشید. </p>
              <p>ایمیل: info [at] kiusk.ca </p>
              </div>');
                        $b->add('pageRule', '<div class="container pt-5">
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
                  <li>ارسال مجدد یک آگهی‌‌ که از زمان حذف آن توسط کاربر، بیش از ۲۴ ساعت سپری نشده باشد،</li>
                </ul>
                </div>
              </div>
              </div>');
            $b->add('PAYPAL_CLIENT_ID', 'AfTF3g1tED5hDzwoKVTbPInHz5MwEOWx_h-Ll0kwOFbiHTijHtzHqPfNLTGxOI2Mmg0YuiUsIW20xg-a');
            $b->add('PAYPAL_SECRET', 'EIN6ERxs2RF57_rR_kq1huFkcUkeegqx5mxkKnW_KxIm0KBIt4WO3JRPeFAfRvLNBwTpJI7RJ8VC13HG');
            $b->add('PAYPAL_MODE', 'sandbox');
            $b->add('seoMeta', json_encode([
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
            $b->add('seoMetaKeywords', json_encode([
                                                    'کیوسک',
                                                    'نیازمندی ها',
                                                    'کانادا',
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
                                                 'title' => 'کیوسک | آگهی رایگان نیازمندی ها و بیزینس های ایرانی در کانادا',
                                                 'description' => 'ثبت اگهی رایگان ایرانی در کانادا، لیست نیازمندی های ایرانی در کانادا، تورنتو، مونترال و ونکوور',
                                                 'url' => null,
                                                 'type' => 'website',
                                                 'site_name' => 'کیوسک',
                                                 'locale' => 'fa_IR',
                                                ]));
            $b->add('seoOpengraphImages', json_encode([]));
            $b->add('seoTwitter', json_encode([
                                               'card' => 'summary_large_image',
                                               'site' => '@',
                                              ]));
            $b->add('seoJsonLd', json_encode([
                                              'title' => 'کیوسک | نیازمندی های ایرانیان کانادا',
                                              'description' => 'ثبت اگهی رایگان ایرانی در کانادا، لیست نیازمندی های ایرانی در کانادا، تورنتو، مونترال و ونکوور',
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

            // Notifications messages
            $b->add('welcome_message', 'به کیوسک خوش آمدید');
            $b->add('created_ad_notification_pending', 'آگهی با موفقیت ایجاد شد.پس از تایید منتشر خواهد شد.');
            $b->add('created_ad_notification_pending_payment', 'آگهی با موفقیت ایجاد شد. آگهی پس از خرید یا ارتقا بسته، تایید و منتشر خواهد شد.');
            $b->add('payment_notification_message', 'این تاییدی است که ما به تازگی پرداخت آنلاین شما را دریافت کرده ایم.');
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
