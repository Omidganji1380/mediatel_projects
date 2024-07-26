<?php

namespace App\Http\Livewire\Front\Ad;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use Illuminate\Support\Facades\App;
use LaravelIdea\Helper\App\Models\Ad\_IH_Category_QB;
use LaravelIdea\Helper\App\Models\Ad\_IH_Favorite_QB;
use LaravelIdea\Helper\Spatie\MediaLibrary\MediaCollections\Models\_IH_Media_QB;
use Livewire\Component;

class LastAds extends Component
{
    public int $page = 0;
    // public Ad $ads;
    public bool $hasPage = true;
    public $category;
    public $banners;
    public $advertisements;
    public $lang;
    // public $ads;

    public function mount()
    {
        $this->lang = App::isLocale('fa') ? '' : 'en.';
        // $this->page = 1;
        // $ads = $this->getAds();
        // dump($ads);
        // $this->hasPage = $ads->hasMorePages();
        // $this->ads = $ads->items();
    }

    public function nextPageaa()
    {
        $this->page = $this->page + 1;
        $ads = $this->getAds();
        $this->hasPage = $ads->hasMorePages();
        array_push($this->ads, ...$ads->items());
    }

    public function render()
    {
        // return view('livewire.front.ad.last-ads');
        return view('livewire.front.ad.last-ads', ['ads' => $this->getAds()]);
    }

    //  public function getAds(): array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\Ad\_IH_Ad_C|\Illuminate\Contracts\Pagination\LengthAwarePaginator
    public function getAds()
    {
    //   $ads = Ad::with([
    //                    'state',
    //                    'city',
    //                    'media' => function ($q) {
    //                         $q->whereCollectionName('SpecialImage');
    //                    },
    //                    'mainCategory',
    //                    'favorites' => function ($q) {
    //                         if (auth()->check()) {
    //                             $q->whereUserId(auth()->id());
    //                         }
    //                    }
    //                   ])
    //            ->whereIsVisible(true)
    //            ->withCount('favorites')
    //            ->ordered('desc')
    //            ->paginate(s()->numberAdsHomePage, '*', 'adsPage', $this->page);


        $ads = Ad::with([
                    'state',
                    'city',
                    'mainCategory',
                    'categories',
                    'media' => function ($q) {
                        $q->whereCollectionName( App::isLocale('fa') ? 'SpecialImage' : 'SpecialImageEn');
                    },
                    'favorites' => function ($q) {
                        if (auth()->check()) {
                            $q->whereUserId(auth()->id());
                        }
                    }
            ])
            // ->where('extra->special', true)
            ->whereHas('categories', function ($query){
                $ids = $this->category->descendants()->pluck('id')->toArray();
                array_push($ids, $this->category->id);
                return $query->whereIn('ad_category_id', $ids);
                // return $query->where('ad_category_id', $this->category->id);
            })
            ->whereIsVisible(true)
            ->withCount('favorites')
            ->where('is_featured', 1)
            ->latest()->take(4)->get();
            // ->latest()->take(8)->get()->chunk(4);
        return $ads;
    }
}
