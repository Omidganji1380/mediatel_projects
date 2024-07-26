<?php

namespace App\Traits;

use App\Models\Ad\Ad;
use App\Models\Advertisement;
use App\Models\Blog\Post;

trait BlogTrait
{
    public function ads()
    {
        return [
            'sidebar_ads' => $this->getAds('blog_sidebar',5),
            'bottom_ads' => $this->getAds('blog_end',6)->chunk(3),
        ];
    }

    public function getAds($position, $count = 1)
    {
        return Advertisement::inRandomOrder()
                ->whereHas('adOrder')
                // ->where('position', $position)
                // ->published()
                ->active()
                ->take($count)->get();
    }

    public function sidebar()
    {
        return [
            'latest_news' => $this->latestNews(),
            'latest_blog' => $this->latestPosts(),
            'top_viewed_blogs' => $this->topViewedPosts(),
            'random_special_ads' => $this->randomSpecialAds()
        ];
    }

    public function latestNews()
    {
        return Post::inRandomOrder()
        ->limit(s()->numberPostsSidebarIndexBlogPage)
        ->get();
    }

    public function latestPosts()
    {
        return Post::latest()
        ->limit(s()->numberPostsSidebarIndexBlogPage)
        ->get();
    }

    public function topViewedPosts()
    {
        return Post::with(['media' => function ($q) {
            $q->whereCollectionName('SpecialImage');
           }])
        ->orderByDesc('views')
        ->limit(s()->numberPostsSidebarIndexBlogPage)
        ->get();
    }

    public function randomSpecialAds()
    {
        return Ad::with(['state', 'city', 'mainCategory',
            'media' => function ($q) {
                $q->whereCollectionName('SpecialImage');
            },
            'favorites' => function ($q) {
                if (auth()->check()) {
                    $q->whereUserId(auth()->id());
                }
            }])
            ->where('is_sidebar_featured', 1)
            // ->where('extra->special', true)
            ->inRandomOrder()->take(s()->numberAdsSimilarShowAdPage)->get();
    }
}
