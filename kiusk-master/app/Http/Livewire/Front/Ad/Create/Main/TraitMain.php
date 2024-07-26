<?php

namespace App\Http\Livewire\Front\Ad\Create\Main;

use App\Jobs\NotifyUsersForApplicants;
use App\Mail\Admins\CreatedAdEmail;
use App\Mail\User\PropertyApplicantMail;
use App\Models\Ad\Ad;
use App\Models\Log;
use App\Models\User;
use App\Notifications\User\CreatedAdNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Mail;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Swift_TransportException;

trait TraitMain
{
    public Ad $ad;
    public $content;
    public $content_en;
    public string $step = 'category';
    public array $formAttributes = [];
    public bool $isEn;
    public bool $showEmail = false;
    public bool $showPhone = false;
    public bool $isFeatured = false;

    public function goTo($to)
    {
        if ($to === 'category') {
            //   $this->resetExcept('categories');
            //   $this->photos = [];
            $this->step = 'category';
            $this->ad = new Ad();
        }
        if ($to === 'form') {
            $this->formAttributes = \App\Models\Ad\Category::find((int)$this->selectedCategory)?->attrs->toArray();
            $this->categoryType = \App\Models\Ad\Category::find($this->selectedCategory)?->type;
            $this->checkPermission();
            $this->step = 'form';
        }
        if($to === 'realEstateDetails'){
            $this->validate($this->realEstateRules);
            $this->categoryType = \App\Models\Ad\Category::find($this->selectedCategory)?->type;
            $this->checkPermission();
            $this->step = 'realEstateDetails';
        }
        if($to === 'realEstateForm'){
            $this->categoryType = \App\Models\Ad\Category::find($this->selectedCategory)?->type;
            $this->checkPermission();
            $this->step = 'realEstateForm';
        }
        if($to === 'facilities'){
            $this->validateRelaEstateDetails();
            $this->getFacilities();
        }
        if ($to === 'realEstateReview') {
            $this->validateFacilities();
            $this->getSelectedFacilities();
        }
        if ($to === 'review') {
            $this->validate($this->adRules);
            // $this->validationAll();
        }
        $this->step = $to;
    }

    // public function updated($V, $n)
    // {
    //     //  dump($V, $n);
    // }

    public function updatedFormAttributes($v)
    {
    }

    public function checkPermission()
    {
        $lang = App::isLocale('fa') ? "" : '/en';
        $policyType = $this->categoryType  . '_create';
        if(!auth()->user()->can($policyType)){
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'error',
                'title' => __('messages.permissions.create_ad_denied'),
                'timerProgressBar' => true,
                'timer' => 20000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300,
            ]);
            return redirect()->to(url($lang . '/my-account/upgrade'));
        }
    }

    /**
     * Store the Ad
     *
     * @return Redirect
     */
    public function store()
    {
        $this->checkPermission();
        $ad = $this->ad;
        $ad->is_visible = false;
        $ad->content = strip_tags($this->content);
        $ad->content_en = strip_tags($this->content_en);
        $ad->user_id = auth()->id();
        $ad->is_visible_email = ! $this->showEmail;
        $ad->is_visible_phone = ! $this->showPhone;
        $ad->is_featured = false;
        $ad->save();
        $this->afterCreateAd($ad);

        $this->categories = [...$this->getFirstParent()];
        $this->reset('backToCategory', 'selectedCategory');
        $this->photos = [];
        $this->ad = new Ad();
        $this->formAttributes = [];

        $user = auth()->user();

        $this->responseMessage(__('messages.ads.created_ad_notification'));
        $ad->setStatus('created');
        $user->notify(new CreatedAdNotification(__('messages.ads.created_ad_notification')));
        $this->createAdNotification($ad);
        return redirect()->to(route($this->lang . 'front.panel.user.ad.index'));
    }

    /**
     * Store ad with type real estate
     *
     * @return Redirect
     */
    public function storeRealEstat()
    {
        $isPropertyApplicant = auth()->user()->getRoleNames()->first() === 'property_applicant';
        $ad = $this->ad;
        $ad->is_visible = false;
        $ad->content = strip_tags($this->content);
        $ad->content_en = strip_tags($this->content_en);
        $ad->user_id = auth()->id();
        $ad->is_visible_email = ! $this->showEmail;
        $ad->is_visible_phone = ! $this->showPhone;
        $ad->is_featured = false;
        $ad->is_property_applicant = $isPropertyApplicant;
        $ad->save();
        $this->afterCreateRealEstate($ad);

        $this->categories = [...$this->getFirstParent()];
        $this->reset('backToCategory', 'selectedCategory');
        $this->photos = [];
        $this->ad = new Ad();
        $this->formAttributes = [];

        $user = auth()->user();

        $this->responseMessage(__('messages.create_ad_pending_payment'));
        $ad->setStatus('created');
        $this->createAdNotification($ad);
        return redirect()->to(route($this->lang . 'front.panel.user.ad.index'));
    }

    /**
     * Dispatch the swal model event to display the message
     *
     * @param string $message
     * @return void
     */
    public function responseMessage($message)
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => $message,
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
        ]);
    }

    /**
     * Validate the inputs
     *
     * @return void
     */
    public function validationAll(): void
    {
        $list = [];
        foreach ($this->formAttributes as $key => $attribute) {
            if ($attribute['validation'] !== null) {
                $list['formAttributes.' . $key . '.text'] = $attribute['validation'];
            }
        }
        $listName = [];
        foreach ($this->formAttributes as $key => $attribute) {
            if ($attribute['validation'] !== null) {
                $listName['formAttributes.' . $key . '.text'] = $attribute['name'];
            }
        }
        $list = array_merge($this->rules, $list);
        $listName = array_merge($this->validationAttributes, $listName);
        $this->validate($list, [], $listName);
    }

    /**
     * Create the subscription usage for user
     *
     * @return User
     */
    public function adSubscriptionStatus()
    {
        $user = Auth::user();
        $this->ad->is_featured ? $user->subscription()->increment('featured_usage') : $user->subscription()->increment('usage');

        return $user->subscriptionUsage($this->ad->is_featured);
    }

    /**
     * Handles the actions after create ad
     *
     * @param Ad $ad
     * @return void
     */
    protected function afterCreateAd($ad): void
    {
        $this->createCategories($ad);
        $this->createMedia($ad);
        $this->createLog($ad);
        $this->createAttributes($ad);
    }

    /**
     * Handles the actions after create ad with type of real estate
     *
     * @param Ad $ad
     * @return void
     */
    protected function afterCreateRealEstate($ad): void
    {
        $this->createCategories($ad);
        $this->createMedia($ad);
        $this->createRealEstateDetails($ad);
        $this->createFacilities($ad);
        $this->createLog($ad);
        $this->createAttributes($ad);
    }

    /**
     * Attach the selected categories to the ad
     *
     * @param Ad $ad
     * @return void
     */
    protected function createCategories($ad): void
    {
        $ad->categories()
           ->attach($this->selectedCategory, ['is_main' => true]);
    }

    /**
     * Create the real estate details and attach to the ad
     *
     * @param Ad $ad
     * @return void
     */
    protected function createRealEstateDetails($ad){
        $ad->realEstateDetail()->create([
            'rooms' => $this->rooms,
            'bathroom' => $this->bathroom,
            'area' => $this->area,
            'availability_date' => $this->availability_date,
            'floor' => $this->floor,
            'sale_price' => $this->sale_price,
            'yearly_tax' => $this->yearly_tax,
            'price_keep' => $this->price_keep,
            'rent_price' => $this->rent_price,
            'mortgage_price' => $this->mortgage_price,
            'area_unit' => $this->area_unit,
            'construction_year' => $this->construction_year,
        ]);
    }

    /**
     * Create the facilities of the real estate ad
     *
     * @param Ad $ad
     * @return void
     */
    protected function createFacilities($ad)
    {
        $ad->facilities()->attach(array_keys($this->adFacilities));
    }

    /**
     * Create Media for Ad
     *
     * @param Ad $ad
     * @return void
     */
    protected function createMedia($ad): void
    {
        \Session::put('paymentObject', $ad->toArray());
        $medias = auth()
                ->user()
                ->media()
                ->whereCollectionName('newAdGalleryWeb')
                ->get();
        foreach ($medias as $key => $media) {
            if ($key === 0) {
                // $photo = Image::load($media)
                //     ->fit(Manipulations::FIT_STRETCH, 1024, 768)
                //     ->save();
                $media->move($ad, 'SpecialImage');
            } else {
                $media->move($ad, 'Gallery');
            }
        }
    }

    /**
     * Create Attriubtes for Ad and attach to the ad
     *
     * @param Ad $ad
     * @return void
     */
    protected function createAttributes($ad): void
    {
        foreach ($this->formAttributes as $attribute) {
            $ad->attrs()->attach($attribute['id'], ['text' => $attribute['text']]);
        }
    }

    /**
     * Create ad's log which user create or updated the ad
     *
     * @param Ad $ad
     * @return void
     */
    protected function createLog($ad): void
    {
        if(Auth::check()){
            $ad->logs()->create([
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }
    }

    /**
     * Handles the send notification for create ad notification
     *
     * @param Ad $ad
     * @return void
     */
    protected function createAdNotification(Ad $ad)
    {
        // Get the admin users
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        // Get the specific ad related to the purchase
        FacadesLog::info('CreatedAdEmailAdmin');
        // Send the email to the admin users
        try {
            Mail::send(new CreatedAdEmail($admins, $ad));
        } catch (Swift_TransportException $exception) {
            FacadesLog::error('Error sending email: ' . $exception->getMessage());
        }

    }
}
