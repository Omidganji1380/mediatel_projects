<?php

namespace App\Http\Controllers;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\User;
use Corcel\Model\Post;
use Corcel\Model\Taxonomy;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\Tag;

class SeedController extends Controller
{
 public function ads()
 {
  return $posts = Post::
//  where('ID', '<',2000);
  //emoji
//   where('ID',1394)->
  type('product')
//   ->limit(20)
                      ->where(function ($q) {
    $q->published()
      ->orWhereIn('post_status', [
       'draft',
       'pending'
      ]);
   })
                      ->chunk(20, function ($posts) {
                       $this->loop($posts);
                      });
 }

 public function userId($post): int
 {
  $WUser = \Corcel\Model\User::find($post->author_id);
  $user = User::whereEmail($WUser->email)
              ->first();
  if ($user) {
//   // dump($WUser);
   return $user->id;
  }
  else {
//  dd($WUser);
   $meta = $WUser->meta;
   foreach ([
             'customer',
             'author',
             'administrator',
             'subscriber'
            ] as $value) {
    if (isset(unserialize($meta->wp_capabilities)[$value])) {
     if ($value == 'administrator') {
      $rule = 'admin';
     }
     else {
      $rule = $value;
     }
    }
   }
   return User::create([
                        'name' => $WUser->user_login,
                        'first_name' => $WUser->first_name,
                        'last_name' => $WUser->last_name,
                        'phone' => $meta->billing_phone,
//                        'birthday',
//                        'address',
//                        'description',
                        'rule' => $rule,
                        'email' => $WUser->email,
                        'email_verified_at' => now(),
                        'password' => $WUser->user_pass,
                        'created_at' => $WUser->created_at
                       ])->id;
  }
 }

// public $count = 0;

 /**
  * @param $posts
  */
 public function loop($posts): void
 {
  foreach ($posts as $post) {
//   if ($this->count > 25) {
//    break;
//   }
   if (Ad::whereSlug(urldecode($post->slug))
         ->exists()) {
    continue;
   }
   \DB::transaction(function () use ($post) {
    $extra = new \stdClass();
    $extra->wordpressId = $post->ID;
    switch ($post->_email_show) {
     case '':
      $is_visible_email = true;
      break;
     case 'on':
      $is_visible_email = false;
      break;
    }
    $visible = true;
    if (in_array($post->status, [
     'draft',
     'pending'
    ])) {
     $visible = false;
    }
    $a = Ad::create([
                     'title' => $post->title,
                     'slug' => urldecode($post->slug),
                     'content' => (string)$post->content,
                     'excerpt' => (string)$post->excerpt,
                     'is_visible' => $visible,
                     'price' => $post->_regular_price,
                     'is_visible_email' => $is_visible_email,
                     'phone' => $post->_custom_phone,
                     'email' => $post->_custom_email,
                     'seo_title' => (string)$post->_yoast_wpseo_title,
                     'seo_description' => (string)$post->_yoast_wpseo_metadesc,
                     'views' => $post->post_views_count,
                     'extra' => $extra,
                     'created_at' => $post->created_at,
                     'updated_at' => $post->updated_at,
                     'user_id' => $this->userId($post),
//   'state_id' => function () {
//    return State::factory()
//                ->create()->id;
//   },
//   'city_id' => function () {
//    return City::factory()
//               ->create()->id;
//   },
                    ]);
//    info($a->content);
//    $this->count++;
   });
  }
 }

 public function tags()
 {
  return $posts = Post::
  with('taxonomies', 'thumbnail', 'attachment')
                      ->type('product')
                      ->where(function ($q) {
                       $q->published()
                         ->orWhereIn('post_status', [
                          'draft',
                          'pending'
                         ]);
                      })
                      ->chunk(20, function ($posts) {
                       foreach ($posts as $post) {
                        $ad = Ad::whereSlug(urldecode($post->slug))
                                ->first();
                        if (!$ad) {
                         continue;
                        }
                        \DB::transaction(function () use ($post, $ad) {
                         foreach ($post->taxonomies as $taxonomy) {
                          switch ($taxonomy->taxonomy) {
                           case 'city_categories':
                            if ($taxonomy->parent && !$ad->city_id) {
                             //city
                             $city = City::firstOrCreate([
                                                          'slug' => urldecode($taxonomy->term->slug),
                                                         ], [
                                                          'name' => $taxonomy->term->name,
//                       'state_id' =>
                                                         ]);
                             $ad->city()
                                ->associate($city);
                             $ad->save();
                            }
                            else if (!$taxonomy->parent && !$ad->state_id) {
                             //state
                             $state = State::firstOrCreate([
                                                            'slug' => urldecode($taxonomy->term->slug),
                                                           ], [
                                                            'name' => $taxonomy->term->name,
                                                           ]);
                             $ad->state()
                                ->associate($state);
                             $ad->save();
                            }
                            break;
                           case 'product_cat':
                            $category = Category::whereSlug(urldecode($taxonomy->term->slug))
                                                ->first();
                            $mainCategoryId = $post->getMeta('_yoast_wpseo_primary_product_cat');
                            if ($mainCategoryId && $mainCategoryId == $taxonomy->term->term_id) {
                             $ad?->categories()
                                 ->attach($category->id, ['is_main' => true]);
                            }
                            else if (!$mainCategoryId || $mainCategoryId !== $taxonomy->term->term_id) {
                             $ad->categories()
                                ->attach($category->id);
                            }
                            break;
                           case 'product_tag':
                            $tag = Tag::where('name->fa', $taxonomy->term->name)
                                      ->first();
                            if ($tag) {
                             $ad->tags()
                                ->syncWithoutDetaching($tag);
                            }
                            else {
                             $ad->tags()
                                ->syncWithoutDetaching(Tag::create([
                                                                    'type' => 'ad',
                                                                    'name' => $taxonomy->term->name,
                                                                   ]));
                            }
                            break;
                          }
                         }
                        });
                        $storeThumbnail = false;
                        foreach ($post->attachment as $key => $attach) {
                         $file = storage_path('app/public/uploads/') . $attach->getMeta('_wp_attached_file');
                         $url = 'https://kiusk.ca/wp-content/uploads/' . $attach->getMeta('_wp_attached_file');
                         if (file_exists($file)) {
                          if ($post?->thumbnail?->attachment->ID == $attach->ID) {
                           $ad->addMedia($file)
//                            ->addMediaFromUrl($url)
                              ->toMediaCollection('SpecialImage');
                          }
                          elseif ($post?->thumbnail == null && $key == 0) {
                           $storeThumbnail = true;
                           $ad->addMedia($file)
//                            ->addMediaFromUrl($url)
                              ->toMediaCollection('SpecialImage');
                          }
                          else {
                           $ad->addMedia($file)
//                            ->addMediaFromUrl($url)
                              ->toMediaCollection('gallery');
                          }
                         }
                        }
                        if ($post?->thumbnail !== null && !$storeThumbnail) {
                         $file = storage_path('app/public/uploads/') . $post?->thumbnail->attachment->getMeta('_wp_attached_file');
                         $url = 'https://kiusk.ca/wp-content/uploads/' . $post?->thumbnail->attachment->getMeta('_wp_attached_file');
                         if (file_exists($file)) {
                          $ad->addMedia($file)
//                           ->addMediaFromUrl($url)
                             ->toMediaCollection('SpecialImage');
                         }
                        }
                       }
                      });
 }

 public function categories()
 {
//  return
  $categories = Taxonomy::where('taxonomy', 'product_cat')
                        ->where('parent', 0)
                        ->get();
  foreach ($categories as $categoryOld) {
   $categoryParent = Category::firstOrCreate([
                                              'slug' => urldecode($categoryOld->term->slug),
                                             ], [
                                              'name' => $categoryOld->term->name,
                                              'description' => $categoryOld->description,
                                              'is_visible' => true,
                                              'position' => $categoryOld->term->term_order
                                             ]);
   $this->children($categoryOld, $categoryParent);
  }
 }

 public function children($categoryOld, $categoryParent): void
 {
  $childrenCategory = Taxonomy::whereParent($categoryOld->term_taxonomy_id)
                              ->get();
  foreach ($childrenCategory as $category) {
   $parent = Category::firstOrCreate([
                                      'slug' => urldecode($category->term->slug),
                                     ], [
                                      'parent_id' => $categoryParent->id,
                                      'name' => $category->term->name,
                                      'description' => $category->description,
                                      'is_visible' => true,
                                      'position' => $category->term->term_order
                                     ]);
   $this->children($category, $parent);
  }
 }

 public function cityCategories()
 {
//  return
  $categories = Taxonomy::where('taxonomy', 'product_cat')
                        ->where('parent', 0)
                        ->get();
  foreach ($categories as $categoryOld) {
   $categoryParent = Category::firstOrCreate([
                                              'slug' => urldecode($categoryOld->term->slug),
                                             ], [
                                              'name' => $categoryOld->term->name,
                                              'description' => $categoryOld->description,
                                              'is_visible' => true,
                                              'position' => $categoryOld->term->term_order
                                             ]);
   $this->children($categoryOld, $categoryParent);
  }
 }

 public function cityChildren($categoryOld, $categoryParent): void
 {
  $childrenCategory = Taxonomy::whereParent($categoryOld->term_taxonomy_id)
                              ->get();
  foreach ($childrenCategory as $category) {
   $parent = Category::firstOrCreate([
                                      'slug' => urldecode($category->term->slug),
                                     ], [
                                      'parent_id' => $categoryParent->id,
                                      'name' => $category->term->name,
                                      'description' => $category->description,
                                      'is_visible' => true,
                                      'position' => $category->term->term_order
                                     ]);
   $this->children($category, $parent);
  }
 }

 public function adAll()
 {
  dump('ads start');
  $this->ads();
  dump('ads end');
  dump('categories start');
  $this->categories();
  dump('categories end');
  dump('tags start');
  $this->tags();
  dump('tags end');
 }
}


