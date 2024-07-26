<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ClientSideSettings extends Settings
{
    // public string $site_name;
    // public bool $site_active;
    public string $copyright;
    public string $favicon;
    public string $logo;
    public string $mainPageAdPlaceholder;
    public string $mainPageAdPlaceholder2;
    public bool $responseCache;
    public string $footerBackgroundImage;
    public string $footerDescription;
    public string $footerTitleMenu;
    public $footerMenuUrls;
    public string $footerTitleContactUs;
    public $footerListContactUs;
    public $headerBlackMenu;
    public $headerMainMenu;
    public int $sequenceCategoryMenu;
    public string $headerText;
    public string $headerTextClose;
    public string $headerBackgroundImage;
    public int $numberAdsHomePage;
    public int $numberBlogPostsHomePage;
    public int $numberAdsCategoryAdPage;
    public int $numberAdsCityCategoryAdPage;
    public int $numberAdsSearchAdPage;
    public int $numberAdsUserShowAdPage;
    public int $numberAdsSimilarShowAdPage;
    public int $numberPostsBlogPage;
    public int $numberPostsBlogNewsPage;
    public int $numberPostsSidebarIndexBlogPage;
    public int $numberAdsSidebarIndexBlogPage;
    public int $numberPostsSidebarShowBlogPage;
    public int $numberAdsSidebarShowBlogPage;
    //تعداد مقالات یا اخبار پایین مقاله یا اخبار
    public int $numberPostsShowBlogPage;
    public string $pageAboutUs;
    public string $pageContactUs;
    public string $pageRule;
    public string $pageKiuskUsers;
    public string $pageScores;
    public string $PAYPAL_CLIENT_ID;
    public string $PAYPAL_SECRET;
    public string $PAYPAL_MODE;
    public $seoMeta;
    public $seoMetaKeywords;
    public $seoMetaWebmasterTags;
    public $seoOpengraph;
    public $seoOpengraphImages;
    public $seoTwitter;
    public $seoJsonLd;
    public $seoJsonLdImages;
    public $allowViewTelescopeUsers;
    public bool $telescopeNightMode;
    public bool $telescopeRecordAll;
    public string $createdAdNotificationPendingPayment;
    // public string $created_ad_notification_pending;
    public $scores;
    public $scoresText;
    public $mainPageCategories;

    // New Settings
    // public string $upgradeLevelDescription;

    public static function group(): string
    {
        return 'general';
    }

    public static function casts(): array
    {
        return [
            'scores' => JsonArray::class,
            'scoresText' => JsonArray::class,
            'mainPageCategories' => JsonArray::class,
            'seoMeta' => JsonArraySeo::class,
            'seoMetaKeywords' => JsonArray::class,
            'seoMetaWebmasterTags' => JsonArray::class,
            'seoOpengraph' => JsonArray::class,
            'seoOpengraphImages' => JsonArray::class,
            'seoTwitter' => JsonArray::class,
            'seoJsonLd' => JsonArray::class,
            'seoJsonLdImages' => JsonArray::class,
            'footerMenuUrls' => JsonArray::class,
            'footerListContactUs' => JsonArray::class,
            'headerBlackMenu' => JsonArray::class,
            'headerMainMenu' => JsonArray::class,
            'allowViewTelescopeUsers' => JsonArray::class,
        ];
    }
}
