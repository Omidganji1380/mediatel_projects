<?php

namespace App\Http\Livewire\Front\Advertisement;

use App\Models\Ad\Category;
use App\Models\AdCart;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\AdvertisementOrder;
use App\Models\AdvertisementType;
use App\Traits\Helper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

class Create extends Component
{
    use WithFileUploads, Helper;

    public $advertisement;
    public $user;
    public $categories;
    public $category_id;
    public $weeks;
    public $price;
    public $prices;
    public $states;
    public $cities = [];
    public AdvertisementOrder $adOrder;

    public $first_name;
    public $last_name;
    public $business_name;
    public $email;
    public $title;
    public $title_en;
    public $description_fa;
    public $description_en;
    public $state_id;
    public $city_id;
    // public $exclusive_design;
    public $logo;
    public $design;
    public $phone;
    public $phone_2;
    public $website;
    public $url;
    public $postal_code;
    public $acceptRules;
    public $tax;

    protected $rules = [
        'first_name' => 'required|string|min:3',
        'last_name' => 'required|string|min:3',
        'business_name' => 'required|string|min:3',
        'email' => 'required|email',
        'website' => 'nullable|min:3|max:30',
        'phone' => 'nullable',
        'phone_2' => 'nullable',
        'title' => 'required|string|min:3|max:50',
        'title_en' => 'required|string|min:3|max:50',
        'description_fa' => 'required|string|min:3|max:120',
        'description_en' => 'required|string|min:3|max:120',
        'state_id' => 'required|integer|exists:address_states,id',
        'city_id' => 'required|integer|exists:address_cities,id',
        'category_id' => 'required|integer|exists:ad_categories,id',
        // 'exclusive_design' => 'nullable|boolean',
        // 'design' => 'nullable|required_if:exclusive_design,true|image|max:10240', // 10 MB,
        // 'logo' => 'nullable|image|max:10240' // 10 MB,
    ];

    public function mount()
    {
        $this->prices = AdvertisementType::PRICES;
        $this->price = $this->prices[$this->weeks] ?? 10;

        // $ids = [31,181,118,15,119,2];
        $ids = Arr::flatten(s()->mainPageCategories);
        $this->categories = Category::with(['ads'])
            ->whereNotNull('extra')
            ->where(function($query){
                $query->whereHas('media', function ($subquery) {
                    $subquery->where('collection_name', 'HomeBGLarge_1');
                })->whereHas('media', function ($subquery) {
                    $subquery->where('collection_name', 'HomeBGLarge_2');
                })->whereHas('media', function ($subquery) {
                    $subquery->where('collection_name', 'BlogBottom_1');
                })->whereHas('media', function ($subquery) {
                    $subquery->where('collection_name', 'BlogBottom_2');
                })->whereHas('media', function ($subquery) {
                    $subquery->where('collection_name', 'BlogText_1');
                })->whereHas('media', function ($subquery) {
                    $subquery->where('collection_name', 'BlogText_2');
                })->whereHas('media', function ($subquery) {
                    $subquery->where('collection_name', 'BlogSidebar_1');
                })->whereHas('media', function ($subquery) {
                    $subquery->where('collection_name', 'BlogSidebar_2');
                });
            })
            ->whereIn('id', $ids)
            ->orderByRaw("FIELD(id, " . implode(',', $ids) . ")")
            ->get();

        if($user = Auth::user()){
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->business_name = $user->business_name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->postal_code = $user->postal_code;
            $this->state_id = $user->state_id;
            $this->city_id = $user->city_id;
            $this->cities = City::where('state_id', $this->state_id)->get();
        }
        $this->states = State::all();
        // $this->load();
    }

    public function load()
    {
        $this->state_id = 1;
        $this->city_id = 1;
        $this->website = 'website.com';
        $this->url = 'http://kiusk.ca/';
        $this->cities = City::where('state_id', 1)->get();
        $this->title = 'معرفی و لیست شغل ها و نیازمندی';
        $this->title_en = 'Introduction and list of Iranian jobs';
        $this->description_fa = 'معرفی و لیست شغل ها و نیازمندی های ایرانی در کانادا، تورنتو';
        $this->description_en = 'Introduction and list of Iranian jobs and requirements in Canada, Toronto, Montreal, Vancouver';

    }

    public function updatedStateId($var)
    {
        $cities = City::where('state_id', $var)->get();
        $this->cities = $cities;
    }

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function store()
    {
        $this->validate();
        $category = Category::find($this->category_id);
        // $BlogSidebar = 'HomeBGLarge_' . rand(1,2);
        // $category = Category::find($this->category_id);
        // $imagePath = $category->getFirstMedia($BlogSidebar)?->getPath();

        // if (!$imagePath || !file_exists($imagePath)) {
        //     throw new \Exception('The image file does not exist.' . ' Type: ' . $category);
        // }

        // $image = Image::make($imagePath);

        // $text = "www.emcode.ir";
        // $text = "+1 812 250 6890";
        // $text = "Innovative Web Design Services for Your Growing Business";
        // $text = "Custom website design: We create unique, customized designs that are tailored to your business and your audience.";
        // $text = "علاوه بر طراحی وب، ما طیف وسیعی از خدمات دیگر";
        // $text = "طراحی وب سایت سفارشی: ما طرح های منحصر به فرد و سفارشی را ایجاد می کنیم که متناسب با کسب و کار شما و مخاطبان شما باشد.";

        // $wrappedText = $this->persianWordwrap($text, 65);

        // $i = 0;

        // foreach($wrappedText as $text){
        //     $text = $this->renderPersianText($text);

        //     $textX = 940;
        //     $textY = 100 + $i;
        //     $size = 18;
        //     $color = "#000";
        //     $align = 'right';
        //     $valign = 'top';

        //     $image->text($text, $textX, $textY, function ($font) use ($size, $color, $align, $valign) {
        //         $font->file(public_path('font/FontsFree-Net-ir_sans (1).ttf')); // Replace with the actual path of your font file
        //         $font->size($size);
        //         $font->color($color); // Text color (white in this example)
        //         $font->align($align);
        //         $font->valign($valign);
        //     });
        //     $i += 24;
        // }

        // Reverse the string
        // $reversedText = $this->mb_strrev($text);

        // dd($reversedText, $text);

        // Apply word wrapping
        // $wrappedText = $this->persian_wordwrap($text, 50);
        // $text = wordwrap($text, 70, "\n");/

        // Reverse the string again
        // $finalText = $this->mb_strrev($wrappedText);


        // $textX = 1074;
        // $textY = 88;
        // $size = 24;
        // $color = "#000";
        // $align = 'left';
        // $valign = 'top';

        // $image->text($text, $textX, $textY, function ($font) use ($size, $color, $align, $valign) {
        //     $font->file(public_path('font/FontsFree-Net-ir_sans (1).ttf')); // Replace with the actual path of your font file
        //     $font->size($size);
        //     $font->color($color); // Text color (white in this example)
        //     $font->align($align);
        //     $font->valign($valign);
        // });



        // $outputFaImagePath = public_path('images/overlay_' . uniqid() . '.jpg');

        // $image->save($outputFaImagePath);
        // dd('test');

        if(Auth::check()){
            $user = Auth::user();
            $this->tax = $tax = s()->defaultTax ?? 13;
            $totalPrice = $this->calculateTotalPriceWithTax($this->price, $tax);
            $days = $this->weeks * 7;
            $adOrder = AdvertisementOrder::create([
                'user_id' => Auth::id(),
                'advertisement_type_id' => $this->advertisement->id,
                'category_id' => $this->category_id,
                'days' => $days,
                'price' => $this->price,
                'total_price' => $totalPrice,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'business_name' => $this->business_name,
                'email' => $this->email,
                'title' => $this->title,
                'title_en' => $this->title_en,
                'description_fa' => $this->description_fa,
                'description_en' => $this->description_en,
                'country_code' => $user->country_code,
                'phone' => $this->phone,
                'phone_2' => $this->phone_2,
                'website' => $this->website,
                'url' => $this->url,
                'postal_code' => $this->postal_code,
                "state_id" => $this->state_id,
                "city_id" => $this->city_id,
                'exclusive_design' => 0,
                'extra' => json_encode([
                    'tax' => $tax,
                ])
            ]);

            $this->adOrder = $adOrder;

            Auth::user()->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'business_name' => $this->business_name,
                'email' => $this->email,
                "state_id" => $this->state_id,
                "city_id" => $this->city_id,
            ]);


            $this->createAndAssignImageToAdOrder(
                $adOrder,
                $category,
                $this->title,
                $this->title_en,
                $this->description_fa,
                $this->description_en,
                $this->phone,
                $this->phone_2,
                $this->website,
            );
            // if($this->logo){
            //     $adOrder->addMedia($this->logo)
            //         ->toMediaCollection('logo');
            // }

            // if($this->exclusive_design && $this->design){
            //     $adOrder->addMedia($this->design)
            //         ->toMediaCollection('design');
            // }

            $adOrder->setStatus('pending_payment');
            $this->addToCart();
        }else{
            return redirect()->to(route('front.signup-phone'));
        }
        return redirect()->to(route('front.user.ad-cart.index'));
    }

    public function addToCart()
    {
        AdCart::updateOrCreate(['user_id' => Auth::id()],
        [
            'advertisement_type_id' => $this->advertisement->id,
            'advertisement_order_id' => $this->adOrder->id,
            'title' => $this->advertisement->name,
            'price' => $this->price,
            'total_price' => $this->adOrder->total_price,
            'tax' => $this->tax,
            'invoice_period' => $this->weeks,
            'description' => $this->advertisement->description,
        ]);
    }

    // public function textOverlay($adOrder)
    // {
    //     $templateImagePath = public_path('images/real_estate_2.jpg'); // Replace with the actual path of your template image

    //     $outputImagePath = public_path('images/overlay_' . uniqid() . '.jpg'); // Store the generated image in the public/images directory

    //     $image = Image::make($templateImagePath);
    //     // $GdImage = \GdImage::make($templateImagePath);

    //     // Calculate the position to center the text on the image
    //     $textX = $image->width() / 2;
    //     $textY = $image->height() / 2;

    //     // Process the text with RTL shaping
    //     $rtlText = $adOrder->title;
    //         // dd($rtlText);
    //     $text  = \PersianRender\PersianRender::render($this->title); //Reversed text for GD

    //     $persianTitle = '';
    //     for ($i = mb_strlen($text); $i>=0; $i--) {
    //         $persianTitle .= mb_substr($text, $i, 1);
    //     }

    //     $image->text($persianTitle, 880, 33, function ($font) {
    //         $font->file(public_path('font/FontsFree-Net-ir_sans (1).ttf')); // Replace with the actual path of your font file
    //         $font->size(24);
    //         $font->color('#ffffe0'); // Text color (white in this example)
    //         $font->align('right');
    //         $font->valign('middle');
    //     });

    //     $image->text($this->description_fa, 880, 132, function ($font) {
    //         $font->file(public_path('font/FontsFree-Net-ir_sans (1).ttf')); // Replace with the actual path of your font file
    //         $font->size(18);
    //         $font->color('#ffffe0'); // Text color (white in this example)
    //         $font->align('right');
    //         $font->valign('middle');
    //     });
    //     $image->save($outputImagePath);

    //     // dd('test');
    //     $adOrder->addMedia($outputImagePath)->toMediaCollection('designFa');

    //     // Now you can associate the generated image with the "order" model
    //     // auth()->user()->orders()->create([
    //     //     'image_path' => 'images/overlay_' . pathinfo($outputImagePath, PATHINFO_BASENAME),
    //     // ]);
    // }

    public function render()
    {
        return view('livewire.front.advertisement.create');
    }
}
