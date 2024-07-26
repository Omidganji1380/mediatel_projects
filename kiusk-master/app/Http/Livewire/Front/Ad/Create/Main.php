<?php

namespace App\Http\Livewire\Front\Ad\Create;

use App\Http\Livewire\Front\Ad\Create\Main\Facility;
use App\Http\Livewire\Front\Ad\Create\Main\Payment;
use App\Http\Livewire\Front\Ad\Create\Main\RealEstate;
use App\Http\Livewire\Front\Ad\Create\Main\StateCity;
use App\Http\Livewire\Front\Ad\Create\Main\TraitMain;
use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Ad\RealEstateDetail;
use App\Models\Payment\Discount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use  Session;

class Main extends Component
{
    use TraitMain;
    use \App\Http\Livewire\Front\Ad\Create\Main\Category;
    use WithFileUploads;
    use StateCity;
    use \App\Http\Livewire\Front\Ad\Create\Main\Media;
    use Payment;
    use RealEstate;
    use Facility;
    use AuthorizesRequests;

    public $lang;

    // public string $step = 'category';
    protected $rules = [
        'ad.title' => 'required|string|min:3',
        'ad.title_en' => 'required|string|min:3',
        'content' => 'required|string',
        'content_en' => 'required|string',
        'ad.price' => 'numeric',
        'ad.state_id' => 'required|numeric',
        'ad.city_id' => '',
        // 'photos.*' => 'image|max:1024',
        // 'photos' => 'array|max:10',
    ];

    protected $adRules = [
        'ad.title' => 'required|string|min:3',
        'ad.title_en' => 'required|string|min:3',
        'content' => 'required|string',
        'content_en' => 'required|string',
        // 'ad.price' => 'numeric',
        'ad.state_id' => 'required|numeric|exists:address_states,id',
        'ad.city_id' => 'required|numeric|exists:address_cities,id',
    ];
    protected $realEstateRules = [
        'ad.title' => 'required|string|min:3',
        'ad.title_en' => 'required|string|min:3',
        'content' => 'required|string',
        'content_en' => 'required|string',
        // 'ad.price' => 'numeric',
        'ad.state_id' => 'required|numeric|exists:address_states,id',
        'ad.city_id' => 'required|numeric|exists:address_cities,id',
        // 'photos.*' => 'image|max:1024',
        // 'photos' => 'array|max:10',
    ];


    public function updated($propertyName, $value)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->ad = new Ad();
        $this->isEn = config('app.locale') == 'en';
        $this->discount = new Discount();
        $this->categories = [...$this->getFirstParent()];
        $this->getPhoto(auth()->user());
        if (\Session::get('goToBuy')) {
            $this->step = 'buy';
            \Session::forget('goToBuy');
        }
        if (Session::get('successPayment')) {
            \Session::forget('goToBuy');
            \Session::forget('paymentObject', );
            Session::forget('successPayment');
        }
        $this->price = $this->totalAmount = 5;
        $this->facilities;
        $this->lang = App::isLocale('fa') ? "" : "en.";
    }

    public function render()
    {
        return view('livewire.front.ad.create.main');
    }

    public function validateOnlyRealEstate($propertyName, $value)
    {
        $validator = Validator::make(
            [
                $propertyName => $value
            ],
            [
                'ad.title' => 'string|min:3',
                'ad.title_en' => 'string|min:3',
            ]
        );

        if($validator->fails()){
            $this->addError($propertyName, $validator->errors()->first($propertyName));
        }
    }
}
