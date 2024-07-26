<?php

namespace App\Http\Controllers\Front\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use App\Models\Redirect;
use App\Traits\BlogTrait;
use App\Traits\RedirectTrait;
use Str;

class BlogController extends Controller
{
    use BlogTrait, RedirectTrait;

    public function frontBlogShow($slug)
    {
        $post = Post::whereSlug($slug)->first();
        if (!$post) {
            return $this->redirect($slug, "blog");
        }

        seo($post);
        $post->increment('views');

        request()->request->add(['post' => $post,]);
        $sidebar = $this->sidebar();

        $sidebarAdsTop = $this->getAds('blog_sidebar', 5);
        $sidebarAdsBottom = $this->getAds('blog_sidebar', 5);

        return view('front.pages.blog.show2', compact('post', 'sidebar', 'sidebarAdsTop', 'sidebarAdsBottom'));
    }

    public function oldFrontBlogShow($y, $m, $d, $slug)
    {
        return $this->redirect($slug, "blog", $y, $m, $d);
    }
    public function oldFrontBlogShowWithPage($y, $m, $d, $slug, $id)
    {
        return $this->redirect($slug, "blog", $y, $m, $d);
    }

    public function frontBlogCategoryIndexBlog($page = 1)
    {
        $category = Category::whereSlug('blog')
            ->firstOrFail();
        seo($category);
        // request()->request->add([
        //     'page' => $page,
        // ]);
        $posts = Post::whereIsVisible(true)
            ->with([
                'media' => function ($q) {
                    $q->whereCollectionName('SpecialImage');
                },
            ])
            ->withCount('favorites')
            ->whereBlogCategoryId($category->id)
            ->latest()
            ->paginate(s()->numberPostsBlogPage)
            ->onEachSide(1);
        $urls = $posts->linkCollection();

        // $urls = $urls->map(function ($item) {
        //     $stringable = Str::of($item['label']);
        //     if ($stringable->contains('Previous')) {
        //         $item['label'] = '&laquo;';
        //     } elseif ($stringable->contains('Next')) {
        //         $item['label'] = '&raquo;';
        //     }
        //     $item['url'] = Str::of($item['url'])
        //         ->replaceMatches("/\/\d+/", '',)
        //         ->replaceMatches("/\?\=/", '/',);

        //     return $item;
        // });
        $sidebar = $this->sidebar();

        $sidebarAdsTop = $this->getAds('blog_sidebar', 5);
        $sidebarAdsBottom = $this->getAds('blog_sidebar', 5);

        return view('front.pages.blog.index2', compact('urls', 'posts', 'sidebar', 'sidebarAdsTop', 'sidebarAdsBottom'));
    }

    public function frontBlogCategoryIndexNews($page = 1)
    {
        $category = Category::whereSlug('blog')
            ->firstOrFail();
        seo($category);
        request()->request->add([
            'page' => $page,
        ]);
        $posts = Post::whereIsVisible(true)
            ->with([
                'media' => function ($q) {
                    $q->whereCollectionName('SpecialImage');
                },
            ])
            ->whereBlogCategoryId($category->id)
            ->latest()
            ->paginate(s()->numberPostsBlogNewsPage, ['*'], '', $page)
            ->onEachSide(1);
        $urls = $posts->linkCollection();
        $urls = $urls->map(function ($item) {
            $stringable = Str::of($item['label']);
            if ($stringable->contains('Previous')) {
                $item['label'] = '&laquo;';
            } elseif ($stringable->contains('Next')) {
                $item['label'] = '&raquo;';
            }
            $item['url'] = Str::of($item['url'])
                ->replaceMatches("/\/\d+/", '',)
                ->replaceMatches("/\?\=/", '/',);

            return $item;
        });

        $sidebar = $this->sidebar();

        return view('front.pages.blog.index2', compact('urls', 'posts', 'sidebar'));
    }

    public function frontBlogTagIndex($slug, $page = 1)
    {
        request()->request->add([
            'page' => $page,
        ]);
        $posts = Post::whereIsVisible(true)
            ->withAllTags([$slug], 'post')
            ->with([
                'media' => function ($q) {
                    $q->whereCollectionName('SpecialImage');
                },
            ])
            ->latest()
            ->paginate(6, ['*'], '', $page)
            ->onEachSide(1);
        $urls = $posts->linkCollection();
        //  return
        $urls = $urls->map(function ($item) {
            $stringable = Str::of($item['label']);
            if ($stringable->contains('Previous')) {
                $item['label'] = '&laquo;';
            } elseif ($stringable->contains('Next')) {
                $item['label'] = '&raquo;';
            }
            $item['url'] = Str::of($item['url'])
                ->replaceMatches("/\/\/page\/\d+/", '',)
                ->replaceMatches("/\?\=/", '//page/',);

            return $item;
        });
        $sidebar = $this->sidebar();

        return view('front.pages.blog.index2', compact('urls', 'posts', 'sidebar'));
    }
}
