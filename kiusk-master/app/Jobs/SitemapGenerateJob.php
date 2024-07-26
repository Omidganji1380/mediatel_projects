<?php

namespace App\Jobs;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Blog\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [];

        $sitemapPages = Sitemap::create()
            ->add(Url::create('/')->setPriority(0.1))
            ->add(Url::create('/login-register')->setPriority(0.1))
            ->add(Url::create('/signup-phone')->setPriority(0.1))
            ->add(Url::create('/site-rules')->setPriority(0.1))
            ->add(Url::create('/contact')->setPriority(0.1))
            ->add(Url::create('/about')->setPriority(0.1))
            ->add(Url::create('/advertisement/create')->setPriority(0.1))
            ->add(Url::create('/listing')->setPriority(0.1))
            ->add(Url::create('/newad')->setPriority(0.1))
            ->add(Url::create('/cart')->setPriority(0.1))
            ->add(Url::create('/ad-cart')->setPriority(0.1))
            ->add(Url::create('/en')->setPriority(0.1))
            ->add(Url::create('/en/login-register')->setPriority(0.1))
            ->add(Url::create('/en/signup-phone')->setPriority(0.1))
            ->add(Url::create('/en/site-rules')->setPriority(0.1))
            ->add(Url::create('/en/contact')->setPriority(0.1))
            ->add(Url::create('/en/about')->setPriority(0.1))
            ->add(Url::create('/en/advertisement/create')->setPriority(0.1))
            ->add(Url::create('/en/listing')->setPriority(0.1))
            ->add(Url::create('/en/newad')->setPriority(0.1))
            ->add(Url::create('/en/cart')->setPriority(0.1))
            ->add(Url::create('/en/ad-cart')->setPriority(0.1));

        $data[] = $sitemapPagesPath = public_path('pages_sitemap.xml');
        $sitemapPages->writeToFile($sitemapPagesPath);

        $sitemapAds = Sitemap::create();
        $adChunk = Ad::all()->chunk(1000);

        foreach($adChunk as $key => $ads){
            $sitemapAds = Sitemap::create();
            foreach($ads as $ad){
                $sitemapAds->add(Url::create("/ads/{$ad->slug}")->setPriority(0.7));
                $sitemapAds->add(Url::create("/en/ads/{$ad->slug}")->setPriority(0.7));
            }
            $data[] = $sitemapAdsPath = public_path("ads_sitemap_{$key}.xml");
            $sitemapAds->writeToFile($sitemapAdsPath);
        }
        $sitemapPosts = Sitemap::create();

        Post::all()->each(function(Post $post) use($sitemapPosts){
            $sitemapPosts->add(Url::create("/blog/{$post->slug}")->setPriority(0.8));
            $sitemapPosts->add(Url::create("/en/blog/{$post->slug}")->setPriority(0.8));
        });

        $data[] = $sitemapPostsPath = public_path('posts_sitemap.xml');
        $sitemapPosts->writeToFile($sitemapPostsPath);

        $sitemapCategory = Sitemap::create();

        Category::all()->each(function(Category $category) use($sitemapCategory){
            $sitemapCategory->add(Url::create("/product-category/{$category->slug}")->setPriority(0.9));
            $sitemapCategory->add(Url::create("/en/blog/{$category->slug}")->setPriority(0.9));
        });

        $data[] = $sitemapCategoriesPath = public_path('categories_sitemap.xml');
        $sitemapCategory->writeToFile($sitemapCategoriesPath);

        $sitemapIndex =  SitemapIndex::create();
        foreach($data as $path){
            $sitemapIndex->add($path);
        }
        $sitemapIndex->writeToFile(public_path('sitemap.xml'));
    }
}
