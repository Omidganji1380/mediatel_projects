<?php

namespace App\Console\Commands;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Blog\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // SitemapGenerator::create('https://kiusk.ca')->writeToFile(public_path('sitemap.xml'));

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
        dump("done");
        return 0;
    }
}
