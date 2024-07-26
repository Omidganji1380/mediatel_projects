<?php

namespace App\Http\Livewire\Front\Auth;

use App\Events\ReferralScoreEvent;
use App\Events\RegisterEvent;
use App\Models\AdminReferral;
use App\Models\Referral;
use App\Models\RegisteredReferral;
use App\Models\User;
use App\Models\VerifyCode;
use App\Notifications\User\SendVerifySms;
use App\Services\Sms\SmsService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Register extends Component
{
    public $currentPage = 1;
    public $verifyCode;
    public $token;
    public $lang;
    public $email;
    public $phone;
    public $password;
    public $countryCode;
    public $role;
    public $roles;
    public $referralCode;

    // public $password_confirmation;
    protected function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone|regex:/^[1-9][0-9]*$/',
            'role' => 'required|in:' . implode(",", array_keys(User::FRONT_USER_ROLES)),
            'password' => [
                'required',
                Password::defaults(),
                //   'confirmed'
            ],
            // 'referralCode' => 'nullable|exists:referrals,referral_code'
            'referralCode' => 'nullable|string'
        ];
    }

    protected $messages = [
        'phone.regex' => 'شماره تلفن بدون صفر شروع شود .مانند:9123456789',
    ];

    public function mount()
    {
        $this->lang = App::isLocale('fa') ? "fa" : "en";
        $this->countryCode = "+1";
        $this->roles = Arr::except(User::FRONT_USER_ROLES, ['vip']);
        $this->referralCode = request('referral_code');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $this->validate();

        if ($this->countryCode != "+1") {
            return $this->addError('countryCode', __('validation.canada_phone'));
        }

        if ($this->token == $this->verifyCode) {

            $referral = null;
            $message = __('messages.register_success');

            if ($this->referralCode) {
                $referral = Referral::where('referral_code', $this->referralCode)->first();
                $adminReferral = AdminReferral::where('code', $this->referralCode)->first();
            }

            $user = User::create([
                'email' => $this->email,
                'phone' => $this->phone,
                'rule' => $this->role,
                'country_code' => $this->countryCode,
                'password' => bcrypt($this->password),
                'referral_id' => $referral?->id ?? null,
                'phone_verified_at' => now()
            ]);
            auth()->login($user);

            VerifyCode::where('phone', $this->phone)->first()?->delete();

            if ($this->referralCode) {
                $referral = Referral::where('referral_code', $this->referralCode)->first();
                if ($referral?->user)
                    ReferralScoreEvent::dispatch($referral->user);

                if($adminReferral){
                    $this->registerReferral($adminReferral, $user);
                    $message = __('messages.register_success_with_referral', [
                        'code' => $adminReferral->code,
                        'point' => $adminReferral->score
                    ]);
                }
            }

            if ($this->role === 'vip') {
                return redirect()->to(route('front.panel.user.plans.vip'));
            } else {
                RegisterEvent::dispatch($user, $this->role);
            }
            App::setLocale( $this->lang );

            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => $message,
                'timerProgressBar' => true,
                'timer' => 1000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300,
            ]);

            $lang = App::isLocal('fa') ? "" : "en.";
            return redirect()->intended(route($lang . 'front.panel.user.ad.index'));
        }else{
            $status = 'error';
            $message = __('messages.phone_not_verified');
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => $status,
                'title' => $message,
                'timerProgressBar' => true,
                'timer' => 20000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300,
            ]);
        }
    }

    public function sendSms()
    {
        $this->validate();
        if ($this->countryCode != "+1") {
            return $this->addError('countryCode', __('validation.canada_phone'));
        }

        if($this->referralCode){
            if (!AdminReferral::whereCode($this->referralCode)->exists() && !Referral::whereReferralCode($this->referralCode)->exists())
                return $this->addError('referralCode', __('validation.referral_code'));
        }
        $this->currentPage++;

        $this->verifyCode = rand(11111, 99999);
        $verifCode = VerifyCode::firstOrCreate(
            ['phone' => $this->phone],
            [
                'country_code' => $this->countryCode,
                'code' => $this->verifyCode
            ]
        );
        $this->verifyCode = $verifCode->code;
        $this->send();
    }

    public function send()
    {
        $message = __('messages.phone_verification_message', ['code' => $this->verifyCode]);
        return app(SmsService::class)->send($this->phone, $message);
    }

    public function registerReferral(AdminReferral $adminReferral, User $user)
    {
        $score = s()->scores['customer']['referral'] ?? 6;
        $adminReferral->increment('count');
        return $adminReferral->registeredReferral()->create([
            'user_id' => $user->id,
            'score' => $adminReferral->score ?: $score
        ]);
    }

    public function render()
    {
        return view('livewire.front.auth.register');
    }
}
