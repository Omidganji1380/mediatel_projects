<?php

namespace App\Filament\Pages;

use App\Settings\ClientSideSettings;
use Artisan;
use App\Models\Ad\Category;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions\ButtonAction;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Str;
use Spatie\ResponseCache\Facades\ResponseCache;

class ClientSideSetting extends SettingsPage
{
    protected static ?string $navigationGroup = 'تنظیمات';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'بخش کاربر';
    protected static ?string $title = 'بخش کاربر';
    protected static string $settings = ClientSideSettings::class;
    public $seoMetaKey;
    public $seoMetaWebmasterTagsKey;

    protected function getFormSchema(): array
    {
        return [
            Section::make('کش کردن')
                ->schema([
                    Toggle::make('responseCache')
                        ->label('کش‌کردن صفحه‌ها'),
                ])
                ->collapsed(),
            Section::make('عمومی')
                ->schema([
                    FileUpload::make('favicon')
                        ->label(__('setting.favicon'))
                        ->directory('setting'),
                    FileUpload::make('logo')
                        ->label(__('setting.logo'))
                        ->directory('setting'),
                ])
                ->collapsed(),
            Section::make(__('Main Page'))
                ->schema([
                    Repeater::make('mainPageCategories')
                        ->schema([
                            Select::make('categories')
                                ->label(__('Categories'))
                                ->options(Category::isVisible()->pluck('name', 'id')->toArray())
                                ->searchable()
                                ->required(),
                        ]),
                    Section::make("تصاویر پیشفرض تبلیغات")
                        ->schema([
                            FileUpload::make('mainPageAdPlaceholder')
                                ->label(__('تصویر پیشفرض تبلیغ 1'))
                                ->directory('setting'),
                            FileUpload::make('mainPageAdPlaceholder2')
                                ->label(__('تصویر پیشفرض تبلیغ 2'))
                                ->directory('setting'),
                        ]),
                ])->collapsed(),
            Section::make('بالا صفحه')
                ->description('در تمام صفحات تکرار می شود . با لاگین تغییر  میکند .در بعضی صفحات فیلد جستجو باز و در بعضی در حالت بسته قرار دارد.')
                ->schema([
                    Section::make('منو سیاه بالا')
                        ->description('url های پیش فرض را ویرایش نکنید.')
                        ->schema([
                            Repeater::make('headerBlackMenu')
                                ->label(__('setting.headerBlackMenu'))
                                ->schema([
                                    TextInput::make('icon')
                                        ->label(__('setting.icon'))
                                        ->required(),
                                    TextInput::make('text')
                                        ->label(__('setting.text'))
                                        ->required(),
                                    TextInput::make('url')
                                        ->label(__('setting.url'))
                                        ->required(),
                                ]),
                        ])
                        ->collapsed(),
                    Section::make('منو اصلی')
                        ->description('url های پیش فرض را ویرایش نکنید.')
                        ->schema([
                            Repeater::make('headerMainMenu')
                                ->label(__('setting.headerMainMenu'))
                                ->schema([
                                    TextInput::make('text')
                                        ->label(__('setting.text'))
                                        ->required(),
                                    TextInput::make('url')
                                        ->label(__('setting.url'))
                                        ->required(),
                                    Repeater::make('submenu')
                                        ->label(__('setting.submenu'))
                                        ->schema([
                                            TextInput::make('text')
                                                ->label(__('setting.text'))
                                                ->required(),
                                            TextInput::make('url')
                                                ->label(__('setting.url'))
                                                ->required(),
                                        ]),
                                ]),
                            TextInput::make('sequenceCategoryMenu')
                                ->label(__('setting.sequenceCategoryMenu'))
                                ->numeric()
                                ->minValue(1),
                        ])
                        ->collapsed(),
                    TextInput::make('headerText')
                        ->label(__('setting.headerText')),
                    TextInput::make('headerTextClose')
                        ->label('متن سرصفحه حالت بسته'),
                    FileUpload::make('headerBackgroundImage')
                        ->label(__('setting.headerBackgroundImage'))
                        ->directory('setting'),
                ])
                ->collapsed(),
            Section::make('پایین صفحه')
                ->description('در تمام صفحات تکرار می شود .')
                ->schema([
                    FileUpload::make('footerBackgroundImage')
                        ->label(__('setting.footerBackgroundImage'))
                        ->directory('setting'),
                    TextInput::make('copyright')
                        ->label(__('setting.copyright')),
                    RichEditor::make('footerDescription')
                        ->label(__('setting.footerDescription'))
                        ->fileAttachmentsDirectory('setting'),
                    TextInput::make('footerTitleMenu')
                        ->label(__('setting.footerTitleMenu')),
                    Section::make('منو')
                        ->description('url های پیش فرض را ویرایش نکنید.')
                        ->schema([
                            Repeater::make('footerMenuUrls')
                                ->label(__('setting.footerMenuUrls'))
                                ->schema([
                                    TextInput::make('text')
                                        ->label(__('setting.text'))
                                        ->required(),
                                    TextInput::make('url')
                                        ->label(__('setting.url'))
                                        ->required(),
                                ]),
                        ])
                        ->collapsed(),
                    TextInput::make('footerTitleContactUs')
                        ->label(__('setting.footerTitleContactUs')),
                    Section::make('لیست اطلاعات تماس')
                        ->description('url های پیش فرض را ویرایش نکنید.')
                        ->schema([
                            Repeater::make('footerListContactUs')
                                ->label(__('setting.footerListContactUs'))
                                ->schema([
                                    TextInput::make('addressIcon')
                                        ->label(__('setting.addressIcon'))
                                        ->required(),
                                    TextInput::make('addressName')
                                        ->label(__('setting.addressName'))
                                        ->required(),
                                    TextInput::make('addressValue')
                                        ->label(__('setting.addressValue'))
                                        ->required(),
                                ]),
                        ])
                        ->collapsed(),
                ])
                ->collapsed(),
            Section::make(__('Scores'))
                ->description(__('Scores for various sections based on roles.'))
                ->schema([
                    Section::make(__('messages.roles.customer'))->schema([
                        Card::make()->schema([
                            TextInput::make('scores.customer.comment')
                                ->label(__('setting.scores.types.comment'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.customer.review')
                                ->label(__('setting.scores.types.review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.customer.rate')
                                ->label(__('setting.scores.types.rate'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.customer.referral')
                                ->label(__('setting.scores.types.referral'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.customer.complete_registration')
                                ->label(__('setting.scores.types.complete_registration'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.customer.google_review')
                                ->label(__('setting.scores.types.google_review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.customer.send_video')
                                ->label(__('setting.scores.types.send_video'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.customer.service_usage')
                                ->label(__('setting.scores.types.service_usage'))
                                ->numeric()
                                ->minValue(1),
                        ])->columns(2),
                    ]),
                    Section::make(__('messages.roles.business_owner'))->schema([
                        Card::make()->schema([
                            TextInput::make('scores.business_owner.comment')
                                ->label(__('setting.scores.types.comment'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.business_owner.review')
                                ->label(__('setting.scores.types.review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.business_owner.rate')
                                ->label(__('setting.scores.types.rate'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.business_owner.referral')
                                ->label(__('setting.scores.types.referral'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.business_owner.complete_registration')
                                ->label(__('setting.scores.types.complete_registration'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.business_owner.google_review')
                                ->label(__('setting.scores.types.google_review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.business_owner.send_video')
                                ->label(__('setting.scores.types.send_video'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.business_owner.service_usage')
                                ->label(__('setting.scores.types.service_usage'))
                                ->numeric()
                                ->minValue(1),
                        ])->columns(2)
                    ]),
                    Section::make(__('messages.roles.seller'))->schema([
                        Card::make()->schema([
                            TextInput::make('scores.seller.comment')
                                ->label(__('setting.scores.types.comment'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.seller.review')
                                ->label(__('setting.scores.types.review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.seller.rate')
                                ->label(__('setting.scores.types.rate'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.seller.referral')
                                ->label(__('setting.scores.types.referral'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.seller.complete_registration')
                                ->label(__('setting.scores.types.complete_registration'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.seller.google_review')
                                ->label(__('setting.scores.types.google_review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.seller.send_video')
                                ->label(__('setting.scores.types.send_video'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.seller.service_usage')
                                ->label(__('setting.scores.types.service_usage'))
                                ->numeric()
                                ->minValue(1),
                        ])->columns(2)
                    ]),
                    Section::make(__('messages.roles.real_estate'))->schema([
                        Card::make()->schema([
                            TextInput::make('scores.real_estate.comment')
                                ->label(__('setting.scores.types.comment'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.real_estate.review')
                                ->label(__('setting.scores.types.review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.real_estate.rate')
                                ->label(__('setting.scores.types.rate'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.real_estate.referral')
                                ->label(__('setting.scores.types.referral'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.real_estate.complete_registration')
                                ->label(__('setting.scores.types.complete_registration'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.real_estate.google_review')
                                ->label(__('setting.scores.types.google_review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.real_estate.send_video')
                                ->label(__('setting.scores.types.send_video'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.real_estate.service_usage')
                                ->label(__('setting.scores.types.service_usage'))
                                ->numeric()
                                ->minValue(1),
                        ])->columns(2)
                    ]),
                    Section::make(__('messages.roles.vip'))->schema([
                        Card::make()->schema([
                            TextInput::make('scores.vip.comment')
                                ->label(__('setting.scores.types.comment'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.vip.review')
                                ->label(__('setting.scores.types.review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.vip.rate')
                                ->label(__('setting.scores.types.rate'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.vip.referral')
                                ->label(__('setting.scores.types.referral'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.vip.complete_registration')
                                ->label(__('setting.scores.types.complete_registration'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.vip.google_review')
                                ->label(__('setting.scores.types.google_review'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.vip.send_video')
                                ->label(__('setting.scores.types.send_video'))
                                ->numeric()
                                ->minValue(1),
                            TextInput::make('scores.vip.service_usage')
                                ->label(__('setting.scores.types.service_usage'))
                                ->numeric()
                                ->minValue(1),
                        ])->columns(2)
                    ]),

                    Section::make(__('Description'))->schema([
                        Section::make(__('Ratings'))->schema([
                            Card::make()->schema([
                                TextInput::make('scoresText.rate.tilte')
                                    ->label(__('setting.scoresText.tilte')),
                                TextInput::make('scoresText.rate.subtilte')
                                    ->label(__('setting.scoresText.subtilte')),
                                TextInput::make('scoresText.rate.icon')
                                    ->label(__('setting.scoresText.icon')),
                                RichEditor::make('scoresText.rate.description')
                                    ->label(__('setting.scoresText.description')),
                            ]),
                        ]),
                        Section::make(__('Comment'))->schema([
                            Card::make()->schema([
                                TextInput::make('scoresText.comment.tilte')
                                    ->label(__('setting.scoresText.tilte')),
                                TextInput::make('scoresText.comment.subtilte')
                                    ->label(__('setting.scoresText.subtilte')),
                                TextInput::make('scoresText.comment.icon')
                                    ->label(__('setting.scoresText.icon')),
                                RichEditor::make('scoresText.comment.description')
                                    ->label(__('setting.scoresText.description')),
                            ]),
                        ]),
                        Section::make(__('Review'))->schema([
                            Card::make()->schema([
                                TextInput::make('scoresText.review.tilte')
                                    ->label(__('setting.scoresText.tilte')),
                                TextInput::make('scoresText.review.subtilte')
                                    ->label(__('setting.scoresText.subtilte')),
                                TextInput::make('scoresText.review.icon')
                                    ->label(__('setting.scoresText.icon')),
                                RichEditor::make('scoresText.review.description')
                                    ->label(__('setting.scoresText.description')),
                            ]),
                        ]),
                        Section::make(__('Referral User'))->schema([
                            Card::make()->schema([
                                TextInput::make('scoresText.referral.tilte')
                                    ->label(__('setting.scoresText.tilte')),
                                TextInput::make('scoresText.referral.subtilte')
                                    ->label(__('setting.scoresText.subtilte')),
                                TextInput::make('scoresText.referral.icon')
                                    ->label(__('setting.scoresText.icon')),
                                RichEditor::make('scoresText.referral.description')
                                    ->label(__('setting.scoresText.description')),
                            ]),
                        ]),
                        Section::make(__('Complete Profile'))->schema([
                            Card::make()->schema([
                                TextInput::make('scoresText.complete_registration.tilte')
                                    ->label(__('setting.scoresText.tilte')),
                                TextInput::make('scoresText.complete_registration.subtilte')
                                    ->label(__('setting.scoresText.subtilte')),
                                TextInput::make('scoresText.complete_registration.icon')
                                    ->label(__('setting.scoresText.icon')),
                                RichEditor::make('scoresText.complete_registration.description')
                                    ->label(__('setting.scoresText.description')),
                            ]),
                        ]),
                        Section::make(__('Google Review'))->schema([
                            Card::make()->schema([
                                TextInput::make('scoresText.google_review.tilte')
                                    ->label(__('setting.scoresText.tilte')),
                                TextInput::make('scoresText.google_review.subtilte')
                                    ->label(__('setting.scoresText.subtilte')),
                                TextInput::make('scoresText.google_review.icon')
                                    ->label(__('setting.scoresText.icon')),
                                RichEditor::make('scoresText.google_review.description')
                                    ->label(__('setting.scoresText.description')),
                            ]),
                        ]),
                        Section::make(__('Upload Video'))->schema([
                            Card::make()->schema([
                                TextInput::make('scoresText.send_video.tilte')
                                    ->label(__('setting.scoresText.tilte')),
                                TextInput::make('scoresText.send_video.subtilte')
                                    ->label(__('setting.scoresText.subtilte')),
                                TextInput::make('scoresText.send_video.icon')
                                    ->label(__('setting.scoresText.icon')),
                                RichEditor::make('scoresText.send_video.description')
                                    ->label(__('setting.scoresText.description')),
                            ]),
                        ]),
                        Section::make(__('Service Usage'))->schema([
                            Card::make()->schema([
                                TextInput::make('scoresText.service_usage.tilte')
                                    ->label(__('setting.scoresText.tilte')),
                                TextInput::make('scoresText.service_usage.subtilte')
                                    ->label(__('setting.scoresText.subtilte')),
                                TextInput::make('scoresText.service_usage.icon')
                                    ->label(__('setting.scoresText.icon')),
                                RichEditor::make('scoresText.service_usage.description')
                                    ->label(__('setting.scoresText.description')),
                            ]),
                        ]),
                    ]),
                ])
                ->collapsed(),
            Section::make('تعداد موارد')
                ->description('تعداد مواردی که  به نمایش در می‌آیند .')
                ->schema([
                    TextInput::make('numberAdsHomePage')
                        ->label(__('setting.numberAdsHomePage'))
                        ->minValue(1),
                    TextInput::make('numberBlogPostsHomePage')
                        ->label(__('setting.numberBlogPostsHomePage'))
                        ->minValue(1),
                    TextInput::make('numberAdsCategoryAdPage')
                        ->label(__('setting.numberAdsCategoryAdPage'))
                        ->minValue(1),
                    TextInput::make('numberAdsCityCategoryAdPage')
                        ->label(__('setting.numberAdsCityCategoryAdPage'))
                        ->minValue(1),
                    TextInput::make('numberAdsSearchAdPage')
                        ->label(__('setting.numberAdsSearchAdPage'))
                        ->minValue(1),
                    TextInput::make('numberAdsUserShowAdPage')
                        ->label(__('setting.numberAdsUserShowAdPage'))
                        ->minValue(1),
                    TextInput::make('numberAdsSimilarShowAdPage')
                        ->label(__('setting.numberAdsSimilarShowAdPage'))
                        ->minValue(1),
                    TextInput::make('numberPostsBlogPage')
                        ->label(__('setting.numberPostsBlogPage'))
                        ->minValue(1),
                    TextInput::make('numberPostsBlogNewsPage')
                        ->label(__('setting.numberPostsBlogNewsPage'))
                        ->minValue(1),
                    TextInput::make('numberPostsSidebarIndexBlogPage')
                        ->label(__('setting.numberPostsSidebarIndexBlogPage'))
                        ->minValue(1),
                    TextInput::make('numberAdsSidebarIndexBlogPage')
                        ->label(__('setting.numberAdsSidebarIndexBlogPage'))
                        ->minValue(1),
                    TextInput::make('numberPostsSidebarShowBlogPage')
                        ->label(__('setting.numberPostsSidebarShowBlogPage'))
                        ->minValue(1),
                    TextInput::make('numberAdsSidebarShowBlogPage')
                        ->label(__('setting.numberAdsSidebarShowBlogPage'))
                        ->minValue(1),
                    TextInput::make('numberPostsShowBlogPage')
                        ->label(__('setting.numberPostsShowBlogPage'))
                        ->minValue(1),
                ])
                ->collapsed(),
            Section::make('صفحه درباره ما')
                ->schema([
                    RichEditor::make('pageAboutUs')
                        ->label(__('setting.pageAboutUs'))
                        ->fileAttachmentsDirectory('setting/page/pageAboutUs'),
                ])
                ->collapsed(),
            Section::make('صفحه تماس باما')
                ->schema([
                    RichEditor::make('pageContactUs')
                        ->label(__('setting.pageContactUs'))
                        ->fileAttachmentsDirectory('setting/page/pageContactUs'),
                ])
                ->collapsed(),
            Section::make(__("Kiusk Users"))
                ->schema([
                    RichEditor::make('pageKiuskUsers')
                        ->label(__('setting.pageKiuskUsers'))
                        ->fileAttachmentsDirectory('setting/page/pageKiuskUsers'),
                ])
                ->collapsed(),
            Section::make(__("Scores Page"))
                ->schema([
                    RichEditor::make('pageScores')
                        ->label(__('setting.pageScores'))
                        ->fileAttachmentsDirectory('setting/page/pageScores'),
                ])
                ->collapsed(),
            Section::make('صفحه قوانین سایت')
                ->schema([
                    RichEditor::make('pageRule')
                        ->label(__('setting.pageRule'))
                        ->fileAttachmentsDirectory('setting/page/pageRule'),
                ])
                ->collapsed(),
            Section::make('درگاه پرداخت پی پال')
                ->schema([
                    TextInput::make('PAYPAL_CLIENT_ID')
                        ->label('Paypal Client Id'),
                    TextInput::make('PAYPAL_SECRET')
                        ->label('Paypal Secret'),
                    TextInput::make('PAYPAL_MODE')
                        ->label('Paypal Mode'),
                ])
                ->collapsed(),
            Section::make('سئو')
                ->schema([
                    KeyValue::make('seoMeta')
                        ->keyLabel('کلید متا')
                        ->valueLabel('مقدار')
                        ->disableDeletingRows()
                        ->disableAddingRows()
                        // ->rules(['array:' . $this->seoMetaKey])
                        ->helperText('برای  نمایش ندادن  یا غیر فعال کردن مقدار تگ را false بگذارید. <br>
                                                 title : در صورت فعال بودن بعد از عنوان هر صفحه می آید. <br>
                                                 titleBefore : در صورت خالی یا false بعد از عنوان می آید در صورت نوشتن  هر متنی قبل از عنوان می  آید.
                                                 canonical : می تواند url یک صفحه باشد .یا برای اینکه آدرس هر صفحه به صورت خودکار قرار بگیرد از کلمه current یا full استفاده کنید یا خالی بگذارید . <br>
                                                 robots : از کلمات none , all , یا ترکیبی از follow/nofollow , index/noindex استفاده کنید.
                                          '),
                    TagsInput::make('seoMetaKeywords'),
                    KeyValue::make('seoMetaWebmasterTags')
                        ->keyLabel('کلید متا')
                        ->valueLabel('مقدار')
                        ->disableDeletingRows()
                        ->disableAddingRows()
                        // ->rules(['array:' . $this->seoMetaWebmasterTagsKey])
                        ->helperText('برای  نمایش ندادن  یا غیر فعال کردن مقدار تگ را خالی بگذارید.'),
                    KeyValue::make('seoOpengraph')
                        ->helperText('برای  نمایش ندادن  یا غیر فعال کردن مقدار تگ را خالی بگذارید. <br>
                                                 url : می تواند url یک صفحه باشد .یا برای اینکه آدرس هر صفحه به صورت خودکار قرار بگیرد  خالی بگذارید . <br>
                                          '),
                    FileUpload::make('seoOpengraphImages')
                        ->multiple()
                        ->directory('setting/seo/opengraph'),
                    KeyValue::make('seoTwitter')
                        ->helperText('برای  نمایش ندادن  یا غیر فعال کردن مقدار تگ را خالی بگذارید.'),
                    KeyValue::make('seoJsonLd')
                        ->helperText('برای  نمایش ندادن  یا غیر فعال کردن مقدار تگ را خالی بگذارید. <br>
                                                 url : می تواند url یک صفحه باشد .یا برای اینکه آدرس هر صفحه به صورت خودکار قرار بگیرد  خالی بگذارید . <br>
                                          '),
                    FileUpload::make('seoJsonLdImages')
                        ->multiple()
                        ->directory('setting/seo/jsonld'),
                ])
                ->collapsed(),
            Section::make('تلسکوپ')
                ->schema([
                    Repeater::make('allowViewTelescopeUsers')
                        ->label(__('setting.allowViewTelescopeUsers'))
                        ->schema([
                            TextInput::make('name')
                                ->label(__('setting.name'))
                                ->required(),
                            TextInput::make('email')
                                ->label(__('setting.email'))
                                ->required(),
                        ]),
                    Toggle::make('telescopeNightMode')
                        ->label(__('setting.telescopeNightMode')),
                    Toggle::make('telescopeRecordAll')
                        ->label(__('setting.telescopeRecordAll')),
                ])
                ->collapsed(),
        ];
    }

    public function mount(): void
    {
        parent::mount();
        $this->data['headerMainMenu'] = collect($this->data['headerMainMenu'])
            ->map(function ($item) {
                $item['url'] = urldecode($item['url']);

                return $item;
            })
            ->toArray();
        $this->data['headerBlackMenu'] = collect($this->data['headerBlackMenu'])
            ->map(function ($item) {
                $item['url'] = urldecode($item['url']);

                return $item;
            })
            ->toArray();
        $this->data['footerMenuUrls'] = collect($this->data['footerMenuUrls'])
            ->map(function ($item) {
                $item['url'] = urldecode($item['url']);

                return $item;
            })
            ->toArray();
        $this->seoMetaKey = implode(',', array_keys($this->data['seoMeta']));
        $this->seoMetaWebmasterTagsKey = implode(',', array_keys($this->data['seoMetaWebmasterTags']));
    }

    public static function getSlug(): string
    {
        return static::$slug ?? Str::kebab(class_basename(static::class));
    }

    protected function getBreadcrumbs(): array
    {
        return [
            '/admin/client-side-setting' => 'تنظیمات',
            'بخش کاربر',
        ];
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('refresh')
                ->label('ریست تنظیمات')
                ->color('danger')
                ->icon('heroicon-s-exclamation-circle')
                ->action('refresh'),
            ButtonAction::make('refresh')
                ->label('پاک کردن کش')
                ->action('removeCache'),
        ];
    }

    public function refresh()
    {
        Artisan::call("migrate:refresh --path=database/settings/2022_02_24_110411_general_reset.php");
        $this->redirect(self::getSlug());
        $this->notify('success', 'تنظیمات ریست شد.');
    }

    public function removeCache()
    {
        ResponseCache::clear();
        $this->notify('success', 'کش پاک شد.');
    }
}
