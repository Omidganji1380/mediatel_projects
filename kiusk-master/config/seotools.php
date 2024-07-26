<?php

/**
 * @see https://github.com/artesaos/seotools
 */
return [
    'meta' => [
        /*
   * The default configurations to be used by the meta generator.
   */
        'defaults' => [
            'title' => "کیوسک | نیازمندی های ایرانیان کانادا",
            // set false to total remove
            'titleBefore' => false,
            // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => 'ثبت اگهی رایگان ایرانی در کانادا، لیست نیازمندی های ایرانی در کانادا، تورنتو، مونترال و ونکوور',
            // set false to total remove
            'separator' => ' | ',
            'keywords' => [
                'کیوسک',
                'نیازمندی ها',
                'کانادا'
            ],
            'canonical' => 'current',
            // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => 'index, follow',
            // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
   * Webmaster tags are always added.
   */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],
        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
   * The default configurations to be used by the opengraph generator.
   */
        'defaults' => [
            'title' => 'کیوسک | آگهی رایگان نیازمندی ها و بیزینس های ایرانی در کانادا',
            // set false to total remove
            'description' => 'ثبت اگهی رایگان ایرانی در کانادا، لیست نیازمندی های ایرانی در کانادا، تورنتو، مونترال و ونکوور',
            // set false to total remove
            'url' => null,
            // Set null for using Url::current(), set false to total remove
            'type' => 'website',
            'site_name' => 'کیوسک',
            'images' => [],
        ],
    ],
    'twitter' => [
        /*
   * The default values to be used by the twitter cards generator.
   */
        'defaults' => [
            'card' => 'summary_large_image',
            'site' => '@',
        ],
    ],
    'json-ld' => [
        /*
   * The default configurations to be used by the json-ld generator.
   */
        'defaults' => [
            'title' => 'کیوسک | نیازمندی های ایرانیان کانادا',
            // set false to total remove
            'description' => 'ثبت اگهی رایگان ایرانی در کانادا، لیست نیازمندی های ایرانی در کانادا، تورنتو، مونترال و ونکوور',
            // set false to total remove
            'url' => null,
            // Set null for using Url::current(), set false to total remove
            'type' => 'WebSite',
            'images' => [],
        ],
    ],
];
return [];
