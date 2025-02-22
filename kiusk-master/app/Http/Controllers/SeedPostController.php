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

class SeedPostController extends Controller
{
 public function posts()
 {
  return $posts = Post::
  type('post')
                      ->where(function ($q) {
                       $q->published()
                         ->orWhereIn('post_status', [
                          'draft',
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
   return $user->id;
  }
  else {
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
//   return
//         $WUser = \Corcel\Model\User::whereId($post->author_id)
//                             ->get()->toArray();
//   if ($this->count > 19) {
//    break;
//   }
   if (\App\Models\Blog\Post::whereSlug(urldecode($post->slug))
                            ->exists()) {
    continue;
   }
   \DB::transaction(function () use ($post) {
    $extra = new \stdClass();
    $extra->wordpressId = $post->ID;
    $visible = true;
    if (in_array($post->status, [
     'draft',
     'pending'
    ])) {
     $visible = false;
    }
    \App\Models\Blog\Post::create([
                                   'title' => $post->title,
                                   'slug' => urldecode($post->slug),
                                   'content' => $post->content,
                                   'excerpt' => $post->excerpt,
                                   'is_visible' => $visible,
//              'price' =>,
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
//    $this->count++;
   });
  }
 }

 public function tags()
 {
  return $posts = Post::
  with('taxonomies', 'attachment', 'thumbnail')
                      ->type('post')
                      ->where(function ($q) {
                       $q->published()
                         ->orWhereIn('post_status', [
                          'draft',
                         ]);
                      })
                      ->chunk(20, function ($posts) {
                       foreach ($posts as $post) {
                        $ad = \App\Models\Blog\Post::whereSlug(urldecode($post->slug))
                                                   ->first();
                        \DB::transaction(function () use ($post, $ad) {
                         foreach ($post->taxonomies as $taxonomy) {
                          switch ($taxonomy->taxonomy) {
                           case 'category':
                            $category = \App\Models\Blog\Category::whereSlug(urldecode($taxonomy->term->slug))
                                                                 ->first();
                            $ad->category()
                               ->associate($category);
                            $ad->save();
                            break;
                           case 'post_tag':
                            $tag = Tag::where('name->fa', $taxonomy->term->name)
                                      ->first();
                            if ($tag) {
                             $ad->tags()
                                ->syncWithoutDetaching($tag);
                            }
                            else {
                             $ad->tags()
                                ->syncWithoutDetaching(Tag::create([
                                                                    'type' => 'post',
                                                                    'name' => $taxonomy->term->name,
                                                                   ]));
                            }
                            break;
                          }
                         }
                         if ($ad->id !== 518 && $ad->id !== 519) {
                          $storeThumbnail = false;
                          $collectionName = 'SpecialImage';
                          $collectionName2 = 'content';
                          foreach ($post->attachment as $key => $attach) {
                           $meta = $attach->getMeta('_wp_attached_file');
                           $file = storage_path('app/public/uploads/') . $meta;
                           $url = 'https://kiusk.ca/wp-content/uploads/' . $meta;
                           if (file_exists($file)) {
                            if ($post?->thumbnail?->attachment->ID == $attach->ID) {
                             $this->addMediaAndUrl($ad, $file, $collectionName, $url, $meta);
                            }
                            elseif ($post?->thumbnail == null && $key == 0) {
                             $storeThumbnail = true;
                             $this->addMediaAndUrl($ad, $file, $collectionName, $url, $meta);
                            }
                            else {
                             $this->addMediaAndUrl($ad, $file, $collectionName2, $url, $meta);
                            }
                           }
                          }
                          if ($post?->thumbnail !== null && !$storeThumbnail) {
                           $meta1 = $post?->thumbnail->attachment->getMeta('_wp_attached_file');
                           $file = storage_path('app/public/uploads/') . $meta1;
                           $url = 'https://kiusk.ca/wp-content/uploads/' . $meta1;
                           if (file_exists($file)) {
                            $this->addMediaAndUrl($ad, $file, $collectionName, $url, $meta1);
                           }
                          }
                         }
                        });
                       }
                      });
 }

 public function categories()
 {
  $categories = Taxonomy::where('taxonomy', 'category')
                        ->where('parent', 0)
                        ->get();
  foreach ($categories as $categoryOld) {
   $categoryParent = \App\Models\Blog\Category::firstOrCreate([
                                                               'slug' => urldecode($categoryOld->term->slug)
                                                              ], [
                                                               'name' => $categoryOld->term->name,
                                                               'description' => $categoryOld->description,
                                                               'is_visible' => true,
//                                              'position' => $categoryOld->term->term_order
                                                              ]);
   $this->children($categoryOld, $categoryParent);
  }
 }

 public function children($categoryOld, $categoryParent): void
 {
  $childrenCategory = Taxonomy::whereParent($categoryOld->term_taxonomy_id)
                              ->get();
  foreach ($childrenCategory as $category) {
   $parent = \App\Models\Blog\Category::firstOrCreate([
                                                       'slug' => urldecode($category->term->slug)
                                                      ], [
                                                       'parent_id' => $categoryParent->id,
                                                       'name' => $category->term->name,
                                                       'description' => $category->description,
                                                       'is_visible' => true,
//                                      'position' => $category->term->term_order
                                                      ]);
   $this->children($category, $parent);
  }
 }

 public function postAll()
 {
  dump('posts start');
  $this->posts();
  dump('posts end');
  dump('categories start');
  $this->categories();
  dump('categories end');
  dump('tags start');
  $this->tags();
  dump('tags end');
 }

 public function addMediaAndUrl(\App\Models\Blog\Post $ad, string $file, string $collectionName, string $url,
                                string                $meta): void
 {
  $media = $ad->addMedia($file)
//                              ->addMediaFromUrl($url)
              ->toMediaCollection($collectionName);
  $urls = $this->urls($ad);
  if (count($urls)) {
   foreach ($urls as $url) {
    if ($url['meta'] == $meta) {
     if (isset($url['responsive'])) {
      $ad->update(['content' => str_replace($url['replace'], $media->original_url, $ad->content)]);
//      $ad->update(['content' => str_replace($url['replace'], $media->getUrl('300x300'), $ad->content)]);
     }
     else {
      $ad->update(['content' => str_replace($url['replace'], $media->original_url, $ad->content)]);
     }
    }
   }
  }
 }

 public function urls($post)
 {
  preg_match_all('/src\s*=\s*"(.+?)"/', $post->content, $matchs, PREG_PATTERN_ORDER, 0);
//  preg_match_all('/http(s*):\/\/kiusk\.ca\/wp-content\/uploads.*\.(?:gif|jpeg|jpg|png|psd|bmp|tiff|tiff|jp2|iff|vnd\.microsoft\.icon|xbm|vnd\.wap\.wbmp|webp|)/',
//                 $post->content, $matchs, PREG_PATTERN_ORDER, 0);
  $list = [];
  foreach ($matchs[1] as $key => $match) {
//  foreach ($matchs[0] as $key => $match) {
   preg_match('/\d+x\d+/', $match, $ms);
   $rr = preg_replace('/-\d+x\d+/', '', $match);
   $meta = preg_replace('/http(s*):\/\/kiusk\.ca\/wp-content\/uploads\//', '', $rr);
   if (count($ms)) {
    $a = [
     'replace' => $match,
     'main' => $rr,
     'meta' => $meta,
     'responsive' => [
      'colection' => $ms[0],
      'w' => (int)explode('x', $ms[0])[0],
      'h' => (int)explode('x', $ms[0])[1]
     ],
    ];
   }
   else {
    $a = [
     'replace' => $match,
     'main' => $rr,
     'meta' => $meta,
    ];
   }
   $list[] = $a;
//   // dump($list);
  }
  return $list;
 }
}


