<?php

use App\Models\Ad\Ad;
use App\Models\Blog\Post;
use App\Models\User;
use App\Settings\ClientSideEnSettings;
use App\Settings\ClientSideSettings;
use App\Settings\TelegramEnSettings;
use App\Settings\TelegramSettings;
use Illuminate\Support\Facades\Auth;

function s(): ClientSideSettings|ClientSideEnSettings
{
    if (config('app.locale') == 'en') {
        return app(ClientSideEnSettings::class);
    }
    return app(ClientSideSettings::class);
}

function st(): TelegramSettings|TelegramEnSettings
{
    if (config('app.locale') == 'en' || Auth::user()?->lang == 'en') {
        return app(TelegramEnSettings::class);
    }
    return app(TelegramSettings::class);
}

function seo($model)
{
    SEO::opengraph()
        ->setType('article');

    if (config('app.locale') == 'fa') {
        if ($seoTitle = $model->seo_title) {
            SEO::setTitle(seoPreviewModel($seoTitle, $model));
        }
        if ($seoDescription = $model->seo_description) {
            SEO::setDescription(seoPreviewModel($seoDescription, $model));
        }
    } else {
        if ($seoTitle = $model->seo_title_en) {
            SEO::setTitle(seoPreviewModel($seoTitle, $model));
        }
        if ($seoDescription = $model->seo_description_en) {
            SEO::setDescription(seoPreviewModel($seoDescription, $model));
        }
    }
    if ($model->getFirstMediaUrl('SpecialImage')) {
        SEO::addImages($model->getFirstMediaUrl('SpecialImage'));
    }
    if ($model->tags->count()) {
        SEO::metatags()
            ->addKeyword($model->tags->pluck('name')
                ->toArray());
    }
    if ($model->rel_canonical) {
        SEO::setCanonical($model->rel_canonical);
    }
    // if($model->no_index){
    //     SEO::setRobots("noindex");
    // }
}

function seoPreviewModel($value, $model)
{
    if ($model instanceof App\Models\Ad\Ad || $model instanceof App\Models\Blog\Post) {
        $property = config('app.locale') == 'fa' ? 'title' : 'title_en';
    } else {
        $property = config('app.locale') == 'fa' ? 'name' : 'name_en';
    }
    if ($model instanceof App\Models\Ad\Ad) {
        $category = $model?->mainCategory->first()?->locale_name;
    } elseif ($model instanceof App\Models\Blog\Post) {
        $category = $model->category?->locale_name;
    } else {
        $category = '';
    }
    $list = getListKeywords();
    $list['%%title%%'] = $model->$property;
    $list['%%primary_category%%'] = $category;
    foreach ($list as $k => $v) {
        $value = str_replace($k, $v, $value);
    }

    return $value;
}

function seoPreview($value, $title, $category = '', $type = 'title')
{
    $list = getListKeywords();
    $list['%%title%%'] = $title;
    $list['%%primary_category%%'] = $category;
    foreach ($list as $k => $v) {
        $value = str_replace($k, $v, $value);
    }
    // $value = addedTitle($type, $value);

    return $value;
}

function addedTitle(mixed $type, string $value): string
{
    if ($type === 'title') {
        if (s()->seoMeta['title']) {
            if (!s()->seoMeta['titleBefore']) {
                $value .= s()->seoMeta['title'];
            } else {
                $value = s()->seoMeta['title'] . $value;
            }
        }
    }

    return $value;
}

function getListKeywords(): array
{
    $list = [
        '%%sep%%' => isset(s()->seoMeta['separator']) ? s()->seoMeta['separator'] : '',
        '%%sitename%%' => isset(s()->seoOpengraph['site_name']) ? s()->seoOpengraph['site_name'] : '',
        '%%title%%' => '',
        '%%page%%' => '',
        //  '%%page%%' => isset(s()->seoMeta['title']) ? s()->seoMeta['title'] : '',
        '%%primary_category%%' => '',
    ];

    return $list;
}

function seoPreviewHelperText($value, $title, $category = '', $type = 'title')
{
    [
        $max,
        $middle
    ] = array_values(seoPreviewLen($type));
    $seoPreview = seoPreview($value, $title, $category, $type);
    $strlen = strlen($seoPreview);
    $text = 'پیش نمایش : ';
    $text .= $seoPreview;
    $text .= '<br>';
    if ($strlen < $middle) {
        $class = '--tw-text-opacity:1;color:rgb(217 119 6/var(--tw-text-opacity))';
    } elseif ($strlen <= $max && $strlen >= $middle) {
        $class = '--tw-text-opacity:1;color:rgb(22 163 74/var(--tw-text-opacity))';
    } elseif ($strlen > $max) {
        $class = '--tw-text-opacity: 1;color: rgb(225 29 72/var(--tw-text-opacity));';
    }
    $text .= "<span style='${class}'>";
    $text .= 'تعداد حروف : ';
    $text .= $strlen;
    $text .= "</span>";
    // $text .= '<br>';
    // $text .= ' تعداد مجاز حروف : ';
    // $text .= $max;
    return $text;
}

function seoPreviewLen($type): array
{
    switch ($type) {
        case 'title':
            $len = [
                'max' => isset(s()->seoMeta['seo_title_max']) ? s()->seoMeta['seo_title_max'] : 255,
                'middle' => isset(s()->seoMeta['seo_title_middle']) ? s()->seoMeta['seo_title_middle'] : 125,
            ];

            break;
        case 'des':
            $len = [
                'max' => isset(s()->seoMeta['seo_description_max']) ? s()->seoMeta['seo_description_max'] : 255,
                'middle' => isset(s()->seoMeta['seo_description_middle']) ? s()->seoMeta['seo_description_middle'] : 125,
            ];

            break;
    }

    return $len;
}

function scorePercentageCalculate($score, $type)
{
    // $blogCount = Post::where('is_visible', true)->count();
    // $adCount = Ad::where('is_visible', true)->count();
    // $usersCount = User::whereHas("roles", function($q){
    //     $q->where("name", "customer")
    //     ->orWhere('name', 'real_estate')
    //     ->orWhere('name', 'vip')
    //     ->orWhere('name', 'seller')
    //     ->orWhere('name', 'business_owner');
    // })->count();

    // $blogAdCount = $blogCount + $adCount;
    $totalAmount = $score > 100 ? $score : 100;
    $percentage = 0;
    switch ($score > 0) {
        case $type === 'comment':
            $percentage = ($score / $totalAmount) * 100;
            break;
        case $type === 'review':
            $percentage = ($score / $totalAmount) * 100;
            break;
        case $type === 'comment_review':
            $percentage = ($score / $totalAmount) * 100;
            break;
        case $type === 'rate':
            $percentage = ($score / $totalAmount) * 100;
            break;
        case $type === 'referral':
            $percentage = ($score / $totalAmount) * 100;
            break;
        case $type === 'complete_registration':
            $percentage = ($score / 1) * 100;
            break;
        case $type === 'google_review':
            $percentage = ($score / 1) * 100;
            break;
        case $type === 'send_video':
            $percentage = ($score / $totalAmount) * 100;
            break;
        case $type === 'service_usage':
            $percentage = ($score / $totalAmount) * 100;
            break;

        default:
            $percentage = 0;
            break;
    }
    return $percentage;
}
