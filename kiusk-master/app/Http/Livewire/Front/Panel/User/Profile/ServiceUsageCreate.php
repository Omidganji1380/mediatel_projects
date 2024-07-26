<?php

namespace App\Http\Livewire\Front\Panel\User\Profile;

use App\Models\Ad\Ad;
use App\Models\ServiceUsage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServiceUsageCreate extends Component
{
    use WithFileUploads;

    public $ad;
    public $ads;
    public $description;
    public $images;

    public function mount()
    {
        $this->ad = request('ad_slug');
        $this->ads = Ad::where('is_visible', true)->latest()->get();
    }

    public function render()
    {
        return view('livewire.front.panel.user.profile.service-usage-create');
    }

    public function upload()
    {
        $this->validate([
            'description' => 'nullable|min:30',
            'ad' => 'required|exists:ads,slug',
            'images' => 'nullable',
            'images.*' => 'required|image|max:10240'
        ]);

        $ad = Ad::whereSlug($this->ad)->firstOrFail();
        $serviceUsage = ServiceUsage::create([
            'ad_id' => $ad->id,
            'user_id' => auth()->id(),
            'description' => $this->description
        ]);

        if($this->images){
            foreach($this->images as $image){
                $serviceUsage->addMedia($image)->toMediaCollection('images');
            }
        }


        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.service_usage_success'),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300
        ]);
    }
}
