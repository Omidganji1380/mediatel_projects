<?php

namespace App\Http\Livewire\Front\Ad;

use App\Http\Controllers\Front\Ad\AdsController;
use App\Models\Ad\Category;
use App\Models\Address\City;
use App\Models\Address\State;
use Livewire\Component;
use Str;

class AdvanceSearch extends Component
{
    public function render()
    {
        if($this->city_id){
            $city = City::find($this->city_id);
            $this->dispatchBrowserEvent('city-name-updated', ['cityName' => $city->name]);
        }
        if($this->state_id){
            $state = State::find($this->state_id);
            $this->dispatchBrowserEvent('state-name-updated', ['stateName' => $state->name]);
        }
        return view('livewire.front.ad.advance-search');
    }

    public string $page = '';
    public string $text = '';
    public int $city_id = 0;
    public int $state_id = 0;
    public int $city = 0;
    public int $state = 0;
    public int $category_id = 0;
    public int $tag_id = 0;
    public string $path = '';
    public $cities;
    //////////////////////////
    public int $min = 0;
    public int $max = 0;
    public bool $specialAd = false;
    public string $sort = '';
    public string $orderBy = '';
    public string $asc = 'asc';
    public array $attributes = [];
    protected $listeners = ['setPage'];
    protected $rules = [
     'min' => 'lte:max',
     'max' => 'gte:min',
    ];
    protected $validationAttributes = [
     'min' => 'کمترین قیمت',
     'max' => 'بیشترین قیمت',
    ];

    public function booted()
    {
        request()->request->add([
                                 'category' => $this->category_id,
                                 'tag' => $this->tag_id,
                                 'path' => $this->path,
                                 's' => $this->text,
                                 'city' => $this->city_id,
                                 'state' => $this->state_id,
                                ]);
    }

    public function mount()
    {
        $this->page = request()->query('page', 1);
        $this->text = request()->query('s') ?? '';
        $this->city_id = request()->query('city_id', 0);
        $this->state_id = request()->query('state_id', 0);
        $this->category_id = request()->query('category', 0);
        $this->tag_id = request()->query('tag', 0);
        $this->path = request()->fullUrl();
        $this->cities = collect();
        $this->states = State::select('id','name')->get();

        if ($this->category_id) {
            $category = Category::with('attrs')
                                ->find($this->category_id);
            $list = [];
            foreach ($category?->attrs?->toArray() as $attribute) {
                $attribute['value'] = '';
                $list = [
                 ...$list,
                 $attribute,
                ];
            }
            $this->attributes = $list;
        }
    }

    public function updatedSort()
    {
        $this->startSearch();
    }

    public function updatedCityId()
    {
        $this->startSearch();
    }

    public function updatedStateId($state)
    {
        $this->city_id = 0;
        $this->startSearch();
        $this->cities = City::where('state_id', $state)->get();
    }

    public function startSearch()
    {
        $this->page = 1;
        $this->startSearchBase();
    }

    public function setPage($page = 1)
    {
        $this->page = $page;
        $this->startSearchBase();
    }

    public function getUrlsSearch($ads): \Illuminate\Support\Collection
    {
        $linkCollection = $ads->linkCollection();
        $urls = $linkCollection->map(function ($item) {
            $item['disabled'] = false;
            $stringable = Str::of($item['label']);
            if ($stringable->contains([
                                       'Next',
                                       'Previous',
                                      ]) && ! $item['url']) {
                $item['disabled'] = true;
            }
            if ($stringable->contains('Previous')) {
                $item['label'] = '&laquo;';
            } elseif ($stringable->contains('Next')) {
                $item['label'] = '&raquo;';
            }
            $item['page'] = (int)(string)Str::of($item['url'])
                                            ->replaceMatches("/^http.*\=/", '', )
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

    public function validationAll(): void
    {
        $list = [];
        //  foreach ($this->attributes as $key => $attribute) {
        //   if ($attribute['validation'] !== null) {
//    $list['attributes.' . $key . '.value'] = $attribute['validation'];
        //   }
        //  }
        $listName = [];
        //  foreach ($this->attributes as $key => $attribute) {
        //   if ($attribute['validation'] !== null) {
//    $listName['attributes.' . $key . '.value'] = $attribute['name'];
        //   }
        //  }
        $list = array_merge($this->rules, $list);
        $listName = array_merge($this->validationAttributes, $listName);
        $this->validate($list, [], $listName);
    }

    public function startSearchBase(): void
    {
        $this->validationAll();
        if ($this->sort) {
            $explode = explode('-', $this->sort);
            $this->orderBy = $explode[0];
            $this->asc = $explode[1];
        } else {
            $this->reset('orderBy', 'asc');
        }
        request()->request->add([
                                 'page' => $this->page,
                                 'min' => $this->min,
                                 'max' => $this->max,
                                 'specialAd' => $this->specialAd,
                                 'orderBy' => $this->orderBy,
                                 'asc' => $this->asc,
                                 'attributes' => $this->attributes,
                                 'category' => $this->category_id,
                                 'tag' => $this->tag_id,
                                 'path' => $this->path,
                                 's' => $this->text,
                                 'city' => $this->city_id,
                                 'state' => $this->state_id,
                                ]);
        $ads = (new AdsController())->searchAds();
        $this->emit('newAds', $ads->items(), $this->getUrlsSearch($ads), 'livewire');
    }
}
