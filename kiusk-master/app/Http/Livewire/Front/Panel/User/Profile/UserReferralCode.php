<?php

namespace App\Http\Livewire\Front\Panel\User\Profile;

use App\Traits\Helper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserReferralCode extends Component
{
    use Helper;

    public $referralCode;
    public $lang;
    public $copied;
    public $userReferralCount;

    public function mount()
    {
        $this->lang = App::isLocale('fa') ? "" : "en.";
        $this->referralCode = auth()->user()->referralCode?->referral_code;
        $this->userReferralCount = auth()->user()?->referralCode?->referrers()?->count() ?? 0;
    }

    public function render()
    {
        return view('livewire.front.panel.user.profile.user-referral-code');
    }

    public function generate()
    {
        $this->referralCode = $this->generateReferralCode(Auth::id());
        Auth::user()->referralCode()->create([
            'referral_code' => $this->referralCode
        ]);
    }

    public function copyToClipboard($text)
    {
        $this->emit('clipboard', $text);
    }
}
