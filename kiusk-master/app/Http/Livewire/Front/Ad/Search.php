<?php

namespace App\Http\Livewire\Front\Ad;

use App\Models\Ad\Category;
use App\Models\Address\State;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Search extends Component
{
    public string $text = '';
    public int $state_id = 0;
    public int $category_id = 0;
    public $categories;
    public $states;
    //$isOpen برای css
    public $isOpen;

    public function mount()
    {
        $this->text = request()->query('s') ?? '';
        $this->state_id = request()->query('state_categories') ?? 0;
        $this->category_id = request()->query('category') ?? 0;
        $this->categories = Category::all();
        $this->states = State::all();
    }

    public function render()
    {
        return view('livewire.front.ad.search');
    }

    public function startSearch()
    {
        $lang = App::isLocale('fa') ? "" : "en.";
        return redirect()->route($lang . 'front.home', [
         's' => $this->text,
         'state_categories' => $this->state_id,
         'category' => $this->category_id,
        ]);
    }
}
