<?php

namespace App\Http\Livewire\Front\Panel\User\Profile;

use App\Models\GoogleLink;
use App\Models\GoogleReview as ModelsGoogleReview;
use Livewire\Component;

class GoogleReview extends Component
{
    public $google_review_url;
    public $links;

    public function mount()
    {
        $this->links = GoogleLink::latest()->get();
    }

    public function render()
    {
        return view('livewire.front.panel.user.profile.google-review');
    }

    public function save()
    {
        $this->validate(['google_review_url' => 'required|url']);

        ModelsGoogleReview::create([
            'user_id' => auth()->id(),
            'url' => $this->google_review_url
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.google_review_success'),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300
        ]);
    }
}
