<?php

namespace App\Http\Livewire\Front\Ad\Search;

use Livewire\Component;

class ListSearch extends Component
{
    public $ads;
    public $urls;
    public $searchType = 'link';
    protected $listeners = ['newAds'];

    public function mount($ads, $urls)
    {
        $this->ads = $ads;
        $this->urls = $urls;
    }

    public function render()
    {
        return view('livewire.front.ad.search.list-search');
    }

    public function newAds($ads, $urls, $searchType = 'link')
    {
        $this->ads = $ads;
        $this->urls = $urls;
        $this->searchType = $searchType;
    }
}
