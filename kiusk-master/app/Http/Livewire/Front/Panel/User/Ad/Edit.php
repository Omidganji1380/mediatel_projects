<?php

namespace App\Http\Livewire\Front\Panel\User\Ad;

use App\Http\Livewire\Front\Panel\User\Ad\Edit\Media;
use App\Models\Ad\Ad;
use App\Models\Ad\AdAttribute;
use App\Models\Ad\Facility;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use Media;
    public $lang;

    public function render()
    {
        return view('livewire.front.panel.user.ad.edit');
    }

    protected $rules = [
        'ad.title' => 'required|string|min:3',
        'ad.title_en' => 'required|string|min:3',
        'ad.content' => 'required|string|min:3',
        'ad.price' => 'required|numeric',
        'ad.state_id' => 'required|numeric',
        'ad.city_id' => 'required|numeric',
        //  'photos.*' => 'image|max:1024',
        //  'photos' => 'array|max:10',
    ];
    protected $validationAttributes = [
        'ad.price' => 'قیمت',
        'ad.state_id' => 'استان',
        'ad.city_id' => 'شهر',
        'photos.*' => 'فایل',
    ];
    public Ad $ad;
    public array $formAttributes = [];
    public $content;
    public $content_en;
    public bool $showEmail = false;
    public bool $showPhone = false;
    public bool $isEn;
    public $categoryType;
    public $facilities;
    public $selectedFacilities;
    public $adFacilities = [];
    public $realEstate;
    public $rooms;
    public $sale_price;
    public $rent_price;
    public $mortgage_price;
    public $area;
    public $area_unit;
    public $bathroom;
    public $yearly_tax;
    public $price_keep;
    public $construction_year;
    public $availability_date;
    public $facility;
    public $nearby_facilities;
    public $building_facilities;
    public $unit_facilities;
    public $floor;
    public $elevator;
    public $warehouse;
    public $balcony;

    public function mount($ad)
    {
        $this->lang = App::isLocale('fa') ? "" : "en.";
        $this->isEn = config('app.locale') == 'en';

        $this->categoryType = $ad->mainCategory?->first()?->type;
        if($this->categoryType === 'real_estate'){
            $this->facilities = Facility::all();
            $this->adFacilities = $ad->facilities->pluck('id', 'id');
            if($ad->realEstateDetail){
                $this->rooms = $ad->realEstateDetail->rooms;
                $this->sale_price = $ad->realEstateDetail->sale_price;
                $this->rent_price = $ad->realEstateDetail->rent_price;
                $this->mortgage_price = $ad->realEstateDetail->mortgage_price;
                $this->area = $ad->realEstateDetail->area;
                $this->area_unit = $ad->realEstateDetail->area_unit;
                $this->bathroom = $ad->realEstateDetail->bathroom;
                $this->yearly_tax = $ad->realEstateDetail->yearly_tax;
                $this->price_keep = $ad->realEstateDetail->price_keep;
                $this->construction_year = $ad->realEstateDetail->construction_year;
                $this->availability_date = $ad->realEstateDetail->availability_date;
                $this->floor = $ad->realEstateDetail->floor;
                $this->elevator = $ad->realEstateDetail->elevator;
                $this->warehouse = $ad->realEstateDetail->warehouse;
                $this->balcony = $ad->realEstateDetail->balcony;
            }
        }

        /**
         * @var Ad $ad
         * */
        $this->getPhoto();
        $list = [];
        foreach ($this->ad->attrs->toArray() as $item) {
            $item['text'] = $item['pivot']['text'];
            $list[] = $item;
        }
        $this->formAttributes = $list;
        $this->showEmail = $ad->is_visible_email;
        $this->showPhone = $ad->is_visible_phone;
        $this->content = strip_tags($ad->content_strip);
        $this->content_en = strip_tags($ad->content_en);
    }



    public function update()
    {
        //  dump($this->formAttributes);
        //
        foreach ($this->formAttributes as $attribute) {
            //   $ad->attrs()->attach([
            //    $attribute['id']=>['text'=>$attribute['text']]
            //                        ]);
            AdAttribute::whereAdId($this->ad->id)
                ->whereAdAttributeId($attribute['id'])
                ->update(['text' => $attribute['text']]);
        }
        $this->ad->update($this->ad->toArray());
        $stdClass = new \stdClass();
        $stdClass->showEmail = $this->showEmail;
        $this->ad->is_visible_email = $this->showEmail;
        $this->ad->is_visible_phone = $this->showPhone;
        $this->ad->extra = $stdClass;
        $this->ad->is_visible = false;
        $this->ad->content = $this->content;
        $this->ad->content_en = $this->content_en;
        $this->ad->save();
        if($this->categoryType === 'real_estate'){
            $this->updateRealEstateDetails();
            $this->updateFacilities();
        }
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.edit', ['name' => __('Ad')]),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
        ]);
    }

    public function updateFacilities() :void
    {
        $this->ad->facilities()->sync(array_keys(array_filter($this->adFacilities->toArray())));
    }

    public function updateRealEstateDetails()
    {
        $this->ad->realEstateDetail->update([
            'rooms' => $this->rooms,
            'sale_price' => $this->sale_price,
            'rent_price' => $this->rent_price,
            'mortgage_price' => $this->mortgage_price,
            'area' => $this->area,
            'area_unit' => $this->area_unit,
            'bathroom' => $this->bathroom,
            'yearly_tax' => $this->yearly_tax,
            'price_keep' => $this->price_keep,
            'construction_year' => $this->construction_year,
            'availability_date' => $this->availability_date,
            'floor' => $this->floor,
            'elevator' => $this->elevator,
            'warehouse' => $this->warehouse,
            'balcony' => $this->balcony,
        ]);
    }
}
