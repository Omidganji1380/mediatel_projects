<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Telescope;
use SEO;

class SettingServiceProvider extends ServiceProvider
{
 /**
  * Register services.
  * @return void
  */
 public function register()
 {
  //
 }

 /**
  * Bootstrap services.
  * @return void
  */
 public function boot()
 {
  /*
   * todo when setting migrate this part must be comment
   * */
  config(['responsecache.enabled' => s()->responseCache]);
  config(['paypal.client_id' => s()->PAYPAL_CLIENT_ID]);
  config(['paypal.secret' => s()->PAYPAL_SECRET]);
  config(['paypal.settings.mode' => s()->PAYPAL_MODE]);
  config([
          'seotools' => [
           'meta' => [
            'defaults' => array_merge(s()->seoMeta, ['keywords' => s()->seoMetaKeywords]),
            'webmaster_tags' => s()->seoMetaWebmasterTags,
            'add_notranslate_class' => false,
           ],
           'opengraph' => [
            'defaults' => array_merge($this->fillterNullWithoutUrl(s()->seoOpengraph),
                                      ['images' => s()->seoOpengraphImages]),
           ],
           'twitter' => [
            'defaults' => $this->fillterNull(s()->seoTwitter),
           ],
           'json-ld' => [
            'defaults' => array_merge($this->fillterNullWithoutUrl(s()->seoJsonLd), ['images' => s()->seoJsonLdImages]),
           ],
          ]
         ]);

     if (s()->telescopeNightMode) {
         Telescope::night();
     }
 }

 public function fillterNull($v)
 {
  return collect($v)
   ->filter(function ($i, $k) {
    return $i !== null;
   })
   ->toArray();
 }

 public function fillterNullWithoutUrl($v)
 {
  return collect($v)
   ->filter(function ($i, $k) {
    if ($k == 'url') {
     return true;
    }
    return $i !== null;
   })
   ->toArray();
 }
}
