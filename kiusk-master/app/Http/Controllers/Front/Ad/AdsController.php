<?php

namespace App\Http\Controllers\Front\Ad;

use App\Http\Controllers\Controller;
use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\Redirect;
use App\Models\Tag;
use App\Traits\BlogTrait;
use App\Traits\RedirectTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LaravelIdea\Helper\App\Models\Ad\_IH_Ad_QB;
use LaravelIdea\Helper\App\Models\Ad\_IH_AdAttribute_QB;
use SEO;
use Str;

class AdsController extends Controller
{
    use BlogTrait, RedirectTrait;

    /**
     * Displays the list of ads with paginate
     *
     * @param integer $page
     * @return View
     */
    public function frontAdIndex($page = 1)
    {
        request()->request->add([
            'page' => $page,
        ]);
        $ads0 = $this->getAdQB(s()->numberAdsHomePage);
        request()->request->add([
            'total_page' => $ads0->lastPage(),
        ]);
        $urls = $this->getUrls($ads0);
        $ads = [];
        foreach ($ads0->items() as $key => $item) {
            $ads[$key] = $item->toArray();
        }

        return view('front.pages.ads.search.index', compact('urls', 'ads'));
    }

    /**
     * Displays the create ad page
     *
     * @return View
     */
    public function frontAdCreate()
    {
        $lang = App::isLocale('fa') ? "" : "en.";
        if(!Auth::user()->email_verified_at){
            return redirect()
            ->to(route($lang . 'front.panel.user.profile.edit') . "#verify-email")
            ->with(['error' => __('messages.verify_email_error')]);
        }
        return view('front.pages.ads.create.create');
    }

    /**
     * Displays the Ad details page
     *
     * @param string $slug
     * @return View
     */
    public function frontAdShow($slug)
    {
        $ad = Ad::with([
            'favorites' => function ($q) {
                if (auth()->check()) {
                    $q->whereUserId(auth()->id());
                }
            },
            'mainCategory',
            'attrs',
            'tags',
        ])
            ->whereSlug($slug)
            ->first();
        if (!$ad) {
            return $this->redirect($slug, "ads");
        }

        seo($ad);
        request()->request->add([
            'ad' => $ad,
        ]);

        return view('front.pages.ads.show', compact('ad'));
    }

    /**
     * Displays the ad search page
     *
     * @param integer $page
     * @return View
     */
    public function frontAdSearch($page = 1)
    {
        request()->request->add([
            'page' => request()->page ?? $page,
            'state' => request()->state_categories,
        ]);
        $ads0 = $this->searchAds();
        $urls = $this->getUrlsSearch($ads0);
        $ads = [];
        foreach ($ads0->items() as $key => $item) {
            $ads[$key] = $item->toArray();
        }

        return view('front.pages.ads.search.index', compact('urls', 'ads'));
    }

    /**
     * Displays the list of ads based on the selected category
     *
     * @param string $slug
     * @param integer $page
     * @return View
     */
    public function frontAdCategoryIndex($slug, $page = 1)
    {
        $category = Category::whereSlug($slug)->first();
        if (!$category) {
            $this->redirect($slug, "product-category");
            // return ;
            dd('inside');
        }

        $this->seoCategory($category);
        request()->request->add([
            'page' => $page,
            'category' => $category->id,
            'category_page' => $category,
        ]);
        $ads0 = $this->getAdQB(s()->numberAdsCategoryAdPage);
        request()->request->add([
            'total_page' => $ads0->lastPage(),
        ]);
        $urls = $this->getUrls($ads0);
        $ads = [];
        foreach ($ads0->items() as $key => $item) {
            $ads[$key] = $item->toArray();
        }

        return view('front.pages.ads.search.index', compact('urls', 'ads', 'category'));
    }

    /**
     * Displays the list of ads based on the selected City or State
     *
     * @param string $slug
     * @param integer $page
     * @return View
     */
    public function frontAdCategoryCityIndex($slug, $page = 1)
    {
        $city = City::whereSlug($slug)
            ->first();
        if ($city) {
            request()->request->add([
                'page' => $page,
                'city' => $city->id,
            ]);
            seo($city);
        } else {
            $state = State::whereSlug($slug)
                ->first();
            if ($state) {
                request()->request->add([
                    'page' => $page,
                    'state' => $state->id,
                ]);
                seo($state);
            } else {
                abort(404);
            }
        }
        $ads0 = $this->getAdQB(s()->numberAdsCityCategoryAdPage);
        $urls = $this->getUrls($ads0);
        $ads = [];
        foreach ($ads0->items() as $key => $item) {
            $ads[$key] = $item->toArray();
        }
        //  return view('front.pages.ads.city-category.index', compact('urls', 'ads', 'city'));
        return view('front.pages.ads.search.index', compact('urls', 'ads'));
    }

    /**
     * Search Ads based on tags
     *
     * @param string $slug
     * @param integer $page
     * @return View
     */
    public function frontAdTagIndex($slug, $page = 1)
    {
        $locale = app()->getLocale();
        $tag = Tag::where("slug->{$locale}", $slug)
            ->whereType('ad')
            ->firstOrFail();
        request()->request->add([
            'page' => $page,
            'tag' => $tag->id,
            'tag_page' => $tag,
        ]);
        //  return
        $ads0 = $this->getAdQB();
        request()->request->add([
            'total_page' => $ads0->lastPage(),
        ]);
        $urls = $this->getUrls($ads0);
        $ads = [];
        foreach ($ads0->items() as $key => $item) {
            $ads[$key] = $item->toArray();
        }

        return view('front.pages.ads.search.index', compact('urls', 'ads'));
    }

    /**
     * Generate the ad's url
     *
     * @param Collection $ads
     * @return \Illuminate\Support\Collection
     */
    public function getUrls($ads): \Illuminate\Support\Collection
    {
        $linkCollection = $ads->linkCollection();
        $urls = $linkCollection->map(function ($item) {
            $item['disabled'] = false;
            $stringable = Str::of($item['label']);
            if ($stringable->contains([
                'Next',
                'Previous',
            ]) && !$item['url']) {
                $item['disabled'] = true;
            }
            if ($stringable->contains('Previous')) {
                $item['label'] = '&laquo;';
            } elseif ($stringable->contains('Next')) {
                $item['label'] = '&raquo;';
            }
            $item['url'] = Str::of($item['url'])
                ->replaceMatches("/\/page\/\d*/", '',)
                ->replaceMatches("/\?/", '/',)
                ->replaceMatches("/\=/", '/',);

            return $item;
        });
        if (count($urls) <= 3) {
            return collect([]);
        }

        return $urls;
    }

    /**
     * Generate the ad's url for search
     *
     * @param Collection $ads
     * @return \Illuminate\Support\Collection
     */
    public function getUrlsSearch($ads): \Illuminate\Support\Collection
    {
        $linkCollection = $ads->linkCollection();
        $urls = $linkCollection->map(function ($item) {
            $item['disabled'] = false;
            $stringable = Str::of($item['label']);
            if ($stringable->contains([
                'Next',
                'Previous',
            ]) && !$item['url']) {
                $item['disabled'] = true;
            }
            if ($stringable->contains('Previous')) {
                $item['label'] = '&laquo;';
            } elseif ($stringable->contains('Next')) {
                $item['label'] = '&raquo;';
            }
            $item['url'] = Str::of($item['url'])
                ->replaceMatches("/\/page\/\d*/", '',)
                //                     ->replaceMatches("/\?/", '/',)
                //                     ->replaceMatches("/\=/", '/',)
            ;

            return $item;
        });
        if (count($urls) <= 3) {
            return collect([]);
        }

        return $urls;
    }

    /**
     * retyrns the searched ads with paginate
     *
     * @return array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\Ad\_IH_Ad_C
     */
    public function searchAds(): array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\Ad\_IH_Ad_C
    {
        return $this->getAdQB(s()->numberAdsSearchAdPage)
            ->withPath(route('front.home'))
            ->withQueryString();
    }

    /**
     * returns the ad query builder with paginate
     *
     * @param integer $prePage
     * @return array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\Ad\_IH_Ad_C
     */
    public function getAdQB($prePage = 16): array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\Ad\_IH_Ad_C
    {
        return Ad::query()
            ->when(request('min') || request('max'), function ($q) {
                $q->whereNotNull('price');
                $q->when(request('min'), function ($q, $v) {
                    $q->where('price', '>=', $v);
                });
                $q->when(request('max'), function ($q, $v) {
                    $q->where('price', '<=', $v);
                });
            })
            ->when(request('state'), function ($q, $v) {
                $q->whereStateId($v);
            })
            ->when(request('city'), function ($q, $v) {
                $q->whereCityId($v);
            })
            ->when(request('s'), function ($q, $v) {
                //            $q->where(function ($q) use ($v) {
                $q->OrWhere(function ($q) use ($v) {
                    $q->OrWhere('title', 'like', '%' . $v . '%')
                        ->OrWhere('content', 'like', '%' . $v . '%')
                        ->orWhereHas('tags', function (Builder $q) use ($v) {
                            $q->where('name->fa', $v);
                        });
                });
            })
            ->when(request('specialAd'), function ($q, $v) {
                $q->where('extra->special', true);
            })
            ->when(request('category'), function ($q, $v) {
                $q->whereHas('categories', function (Builder $q) use ($v) {
                    $q->where('ad_categories.id', $v)
                        ->orWhere('ad_categories.parent_id', $v);
                });
            })
            ->when(request('tag'), function ($q, $v) {
                $q->whereHas('tags', function (Builder $q) use ($v) {
                    $q->where("tags.id", $v)
                        ->whereType('ad');
                });
            })
            ->when(request('orderBy'), function ($q, $v) {
                $q->when(request('asc'), function ($q, $asc) use ($v) {
                    $q->orderBy($v, $asc);
                });
            })
            //           ->when(request('orderBy') !== 'created_at', function ($q, $v) {
            //            $q->ordered();
            //           })
            ->ordered()
            ->when(request('attributes'), function (/*_IH_Ad_QB*/$q, $v) {
                $hasValue = false;
                foreach ($v as $item) {
                    if ($item['value']) {
                        $hasValue = true;

                        break;
                    }
                }
                if ($hasValue) {
                    $q->whereHas('attrs', function (/*_IH_AdAttribute_QB*/$q) use ($v) {
                        foreach ($v as $attribute) {
                            $q->when($attribute['value'], function ($q, $v) use ($attribute) {
                                $q->where(function ($q) use ($attribute) {
                                    $q->whereAdAttributeId($attribute['id']);
                                    if ($attribute['value'] !== 'all') {
                                        switch ($attribute['type']) {
                                            case 'Text':
                                            case 'Select':
                                                $q->whereText($attribute['value']);

                                                break;
                                        }
                                    }
                                });
                            });
                        }
                    });
                }
            })
            ->whereIsVisible(true)
            ->with([
                'state',
                'city',
                'media' => function ($q) {
                    $q->whereCollectionName('SpecialImage');
                },
                'mainCategory',
                'favorites' => function ($q) {
                    if (auth()->check()) {
                        $q->whereUserId(auth()->id());
                    }
                },
            ])
            ->paginate($prePage);
    }

    /**
     * @param Category $model
     */
    public function seoCategory($model)
    {
        SEO::opengraph()
            ->setType('article');
        if ($seoTitle = $model->seo_title) {
            SEO::setTitle(seoPreviewModel($seoTitle, $model));
        } else {
            if ($name = $model->name) {
                SEO::setTitle($name);
            }
        }
        if ($seoDescription = $model->seo_description) {
            SEO::setDescription(seoPreviewModel($seoDescription, $model));
        } else {
            if ($description = $model->description) {
                SEO::setDescription($description);
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
    }
}
