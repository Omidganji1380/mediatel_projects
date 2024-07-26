<?php

namespace App\Http\Livewire\Front\Auth;

use App\Events\RegisterEvent;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SignupPhone extends Component
{
    public $countries;
    public $country_code;
    public $phone;
    public $sent_code;
    public $otp;
    public $otpSent = false;
    public $user;
    public $lang;

    protected $rules = [
        'country_code' => 'required|integer|exists:countries,id',
        'phone' => 'required|numeric',
        'sent_code' => 'nullable|numeric',
    ];
    protected $otpRules = [
        'sent_code' => 'required|numeric',
    ];

    public function mount()
    {
        $this->countries = Country::all();
        $this->country_code = 38;
        $this->lang = App::isLocale('fa') ? "fa" : "en";
        // $this->phone = $user->phone;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function sendSms()
    {

        $this->validate($this->rules);
        $user = User::where('phone', $this->phone)->first();
        $countryCode = Country::find($this->country_code);
        if($countryCode->dial_code != "+1"){
            return $this->addError('phone', __('validation.canada_phone'));
        }

        $otp = $this->generateOtp();
        if(!$user){
            $this->user = User::create([
                'country_code' => $countryCode->dial_code,
                'phone' => $this->phone,
                'phone_verify_code' => $otp,
                'email' => $this->generateEmail(),
            ]);
            RegisterEvent::dispatch($this->user);
        }else{
            $message = __('messages.verify_code_sms', ['code' => $otp]);
            app(\App\Services\Sms\SmsService::class)->send($this->phone, $message);
            $user->update(['phone_verify_code' => $otp]);
            $this->user = $user;
        }
        App::setLocale( $this->lang );

        $this->otpSent = true;
    }

    public function generateOtp()
    {
        $randDigit = rand(11111, 99999);
        $this->otp = $randDigit;
        return $randDigit;
    }

    public function generateEmail()
    {
        return now()->timestamp . "@email.com";
    }

    public function confirm()
    {
        $this->validate($this->otpRules);
        // dd($this->sent_code == $this->otp);
        App::setLocale( $this->lang );
        if($this->sent_code == $this->otp){
            $this->user->update([
                'phone_verified_at' => now(),
                'phone_verify_code' => null,
            ]);
            Auth::login($this->user);
            $lang = App::isLocale('fa') ? "" : "en.";
            return redirect()->route($lang .'front.advertisement.index');
        }
        $this->addError('sent_code', __('validation.invalid_otp'));

    }

    public function render()
    {
        return view('livewire.front.auth.signup-phone');
    }
}
