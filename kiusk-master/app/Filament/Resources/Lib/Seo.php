<?php

namespace App\Filament\Resources\Lib;

use App\Models\Ad\Ad;
use App\Models\Blog\Post;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;

trait Seo
{
    public $keywords;

    public static function seoInputs($relatedInput = 'title'): Card
    {
        $components = [
            TextInput::make('seo_description')
                ->label(__('admin.seo_description'))
                //   ->reactive()
                ->helperText(function ($state, Closure $get) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText($state, $get($relatedInput), '', 'des');
                }),
            TextInput::make('seo_title')
                ->label(__('admin.seo_title'))
                //   ->reactive()
                ->helperText(function ($state, Closure $get) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText($state, $get($relatedInput));
                }),
            TextInput::make('seo_description_en')
                ->label(__('admin.seo_description_en'))
                //   ->reactive()
                ->helperText(function ($state, Closure $get) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText($state, $get($relatedInput), '', 'des');
                }),
            TextInput::make('seo_title_en')
                ->label(__('admin.seo_title_en'))
                //   ->reactive()
                ->helperText(function ($state, Closure $get) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText($state, $get($relatedInput));
                }),
        ];
        //  $components = self::getKeywords($components);
        return Card::make()
            ->schema($components)
            ->columnSpan(3);
    }

    public static function seoInputsAd($relatedInput = 'title'): Card
    {
        $components = [
            TextInput::make('seo_description')
                //            ->hint()
                ->label(__('admin.seo_description'))
                ->reactive()
                ->helperText(function ($state, Closure $get, ?Ad $record) use ($relatedInput) {
                    return self::getKeywords('des') . '<br>' . seoPreviewHelperText(
                        $state,
                        $get($relatedInput),
                        $record?->mainCategory?->first()?->name,
                        'des'
                    );
                }),
            TextInput::make('seo_title')
                ->label(__('admin.seo_title'))
                ->reactive()
                ->helperText(function ($state, Closure $get, ?Ad $record) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText(
                        $state,
                        $get($relatedInput),
                        $record?->mainCategory?->first()?->name
                    );
                }),
            TextInput::make('seo_description_en')
                //            ->hint()
                ->label(__('admin.seo_description_en'))
                ->reactive()
                ->helperText(function ($state, Closure $get, ?Ad $record) use ($relatedInput) {
                    return self::getKeywords('des') . '<br>' . seoPreviewHelperText(
                        $state,
                        $get($relatedInput),
                        $record?->mainCategory?->first()?->name,
                        'des'
                    );
                }),
            TextInput::make('seo_title_en')
                ->label(__('admin.seo_title_en'))
                ->reactive()
                ->helperText(function ($state, Closure $get, ?Ad $record) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText(
                        $state,
                        $get($relatedInput),
                        $record?->mainCategory?->first()?->name
                    );
                }),
        ];
        //  $components = self::getKeywords($components);
        return Card::make()
            ->schema($components)
            ->columnSpan(3);
    }

    public static function seoInputsPost($relatedInput = 'title'): Card
    {
        $components = [
            TextInput::make('seo_description')
                ->label(__('admin.seo_description'))
                ->reactive()
                ->helperText(function ($state, Closure $get, ?Post $record) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText(
                        $state,
                        $get($relatedInput),
                        $record?->category?->name,
                        'des'
                    );
                }),
            TextInput::make('seo_title')
                ->label(__('admin.seo_title'))
                ->reactive()
                ->helperText(function ($state, Closure $get, ?Post $record) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText(
                        $state,
                        $get($relatedInput),
                        $record?->category?->name
                    );
                }),
            TextInput::make('seo_description_en')
                ->label(__('admin.seo_description_en'))
                ->reactive()
                ->helperText(function ($state, Closure $get, ?Post $record) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText(
                        $state,
                        $get($relatedInput),
                        $record?->category?->name,
                        'des'
                    );
                }),
            TextInput::make('seo_title_en')
                ->label(__('admin.seo_title_en'))
                ->reactive()
                ->helperText(function ($state, Closure $get, ?Post $record) use ($relatedInput) {
                    return self::getKeywords() . '<br>' . seoPreviewHelperText(
                        $state,
                        $get($relatedInput),
                        $record?->category?->name
                    );
                }),
        ];
        //  $components = self::getKeywords($components);
        return Card::make()
            ->schema($components)
            ->columnSpan(3);
    }

    public static function getKeywords($type = 'title')
    {
        $list = getListKeywords();
        $str = '';
        if (count($list)) {
            $arrayKeys = array_keys($list);
            foreach ($arrayKeys as $key => $value) {
                $arrayKeys[$key] = "<span  class='bg-yellow-500	border border-orange-300 rounded-sm outline-dotted outline-2 outline-offset-2 hover:outline-dashed shadow-md hover:rotate-45 cursor-pointer	' id=\"keyword${key}${type}\" onclick=\"copyKeyword('keyword${key}${type}')\">" . $value . '</span>';
            }
            $str = 'عبارات با کلیک کپی می‌شوند : ' . implode(' ', $arrayKeys);
        }
        return $str;
    }
    /* public static function getKeywords(array $components): array
     {
      $list = getListKeywords();
      if (count($list)) {
       $arrayKeys = array_keys($list);
       foreach ($arrayKeys as $key=>$value) {
        $arrayKeys[$key] = "<span id='keyword${key}' onclick='copyKeyword('keyword${key}')'>" . $value . '</span>';
       }
       $str = 'عبارات : ' . implode(' و ', $arrayKeys);
       $components = [
        Placeholder::make('user_id')
                   ->label('')
                   ->content(fn(): string => $str),
        ...$components,
       ];
      }
      return $components;
     }*/
}
