<?php

namespace App\Http\Livewire\Front\Auth;

use App\Models\User;
use App\Repositories\CustomTokenRepository;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as RulePassword;
use Livewire\Component;
use Mail;
use Password;
use Str;
use Swift_TransportException;
use Telegram\Bot\Api;

class ForgetPassword extends Component
{
    protected $listeners = ['toggleFormForgetPassword'];
    public bool $showForm = false;
    public string $username = "";
    public $user;
    public $password;
    public $password_confirmation;
    public $token;
    public $isTokenSent = false;
    public $isPhone = false;
    public $checked = false;
    public $sendViaSms = false;

    protected function rules()
    {
        return [
            'username' => 'required',
            'password' => [
                'required',
                'confirmed',
                RulePassword::defaults()
            ],
            'password_confirmation' => 'required',
            'token' => 'required',
        ];
    }

    protected $validationAttributes = [
        'username' => 'ایمیل یا شماره موبایل'
    ];

    public function render()
    {
        return view('livewire.front.auth.forget-password');
    }

    public function checkUsername()
    {
        $this->validateOnly('username');

        if ($this->getColumnName() === 'email') {
            $validator = Validator::make([$this->getColumnName() => $this->username], [
                $this->getColumnName() => 'required|email|exists:users,email',
            ]);
            if (!$validator->fails()) {
                $this->sendToken();
            }
        }
        if ($this->getColumnName() === 'phone') {
            $validator = Validator::make([$this->getColumnName() => $this->username], [
                $this->getColumnName() => 'required|exists:users,phone',
            ]);

            if (!$validator->fails()) {
                $this->isPhone = true;
                $this->checked = true;
            }

            $this->user = $user = User::where('phone', $this->username)->first();

            if ($user) {
                $this->sendViaSms = $user->send_code_via_telegram;
            } else {
                $this->addError('username', __('passwords.user'));
            }
        }

        if ($validator->fails()) {
            $this->addError('username', __('messages.forgot_password_error'));
            return;
        }
    }

    public function sendToken()
    {
        $this->user = $user = User::where('phone', $this->username)->orWhere('email', $this->username)->first();
        if ($user) {
            $this->checked = true;
            $this->isTokenSent = true;
            $this->isPhone = false;

            $token = $this->createToken($user);

            if ($this->getColumnName() === 'phone') {



                if (!$this->sendViaSms) {
                    $smsMessage = __('messages.forgot_password_sms', ['token' => $token]);
                    app(\App\Services\Sms\SmsService::class)->send($user->phone, $smsMessage);
                } else {
                    $t = new Api(st()->botApiToken);
                    $text = __('messages.forgot_password_text');
                    $t->sendMessage([
                        'chat_id' => $user->telegram_id,
                        'text' => $text,
                    ]);
                    $t->sendMessage([
                        'chat_id' => $user->telegram_id,
                        'text' => $token,
                    ]);
                }
            }

            if ($this->getColumnName() === 'email') {
                try {
                    Mail::to($user)
                    ->send(new \App\Mail\ForgetPassword($token));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }

            }

            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => $this->isEmail() ? __('passwords.sent') : ($this->sendViaSms ? __('passwords.sent_to_telegram') : __('passwords.sent_via_sms')),
                'timerProgressBar' => true,
                'timer' => 30000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300
            ]);
        } else {
            $this->addError('username', __('passwords.user'));
        }



        // $status = Password::sendResetLink([
        //     $this->getColumnName() => $this->username,
        // ], function ($user, $token) {


        //     /**
        //      * @var User $user
        //      */
        //     if ($this->getColumnName() === 'email') {
        //         Mail::to($user)
        //             ->send(new \App\Mail\ForgetPassword($token));
        //     } elseif ($this->getColumnName() === 'phone') {

        //         $smsMessage = __('messages.forgot_password_sms', ['token' => $token]);
        //         app(\App\Services\Sms\SmsService::class)->send($user->phone, $smsMessage);
        //         // $t = new Api(st()->botApiToken);
        //         // $text = __('messages.forgot_password_text');
        //         // $t->sendMessage([
        //         //     'chat_id' => $user->telegram_id,
        //         //     'text' => $text,
        //         // ]);
        //         // $t->sendMessage([
        //         //     'chat_id' => $user->telegram_id,
        //         //     'text' => $token,
        //         // ]);
        //     }
        // });
        // if ($status === Password::RESET_LINK_SENT) {

        // } else {
        //     $this->dispatchBrowserEvent('swal:modal', [
        //         'icon' => 'error',
        //         'title' => __($status),
        //         'timerProgressBar' => true,
        //         'timer' => 30000,
        //         'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
        //         'width' => 300
        //     ]);
        // }
    }

    public function store()
    {
        $this->validate();

        if ($this->checkToken()) {
            $this->user->forceFill([
                'password' => Hash::make($this->password)
            ])
                ->setRememberToken(Str::random(60));
            $this->user->save();
            event(new PasswordReset($this->user));

            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => __('passwords.reset'),
                'timerProgressBar' => true,
                'timer' => 30000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300
            ]);
            $this->user->update([
                'phone_verify_code' => null,
                'email_verify_code' => null,
            ]);
            $this->backToLogin();
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'error',
                'title' => __('passwords.token'),
                'timerProgressBar' => true,
                'timer' => 30000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300
            ]);
        }

        // $status = Password::reset([
        //     $this->getColumnName() => $this->username,
        //     'password' => $this->password,
        //     'token' => $this->token
        // ], function ($user, $password) {

        // });
        // if ($status === Password::PASSWORD_RESET) {
        //     $this->dispatchBrowserEvent('swal:modal', [
        //         'icon' => 'success',
        //         'title' => __($status),
        //         'timerProgressBar' => true,
        //         'timer' => 30000,
        //         'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
        //         'width' => 300
        //     ]);
        //     $this->backToLogin();
        // } else {
        //     $this->dispatchBrowserEvent('swal:modal', [
        //         'icon' => 'error',
        //         'title' => __($status),
        //         'timerProgressBar' => true,
        //         'timer' => 30000,
        //         'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
        //         'width' => 300
        //     ]);
        // }
    }

    public function toggleFormForgetPassword()
    {
        $this->showForm = !$this->showForm;
    }

    public function backToLogin()
    {
        $this->emit('toggleFormLogin');
        $this->toggleFormForgetPassword();
    }

    protected function getColumnName(): string
    {
        $columnName = \Validator::make(['username' => $this->username], [
            'username' => 'email',
        ])
            ->passes() ? 'email' : 'phone';
        return $columnName;
    }

    protected function isEmail(): bool
    {
        // return $status === 'passwords.sent' && $this->getColumnName() === 'email';
        return $this->getColumnName() === 'email';
    }

    protected function createToken($user): int
    {
        $token = rand(10000, 99999);
        if ($this->getColumnName() === 'email') {
            $user->update(['email_verify_code' => $token]);
        }
        if ($this->getColumnName() === 'phone') {
            $user->update(['phone_verify_code' => $token]);
        }
        return $token;
    }

    protected function checkToken(): int
    {
        $column = $this->getColumnName() . '_verify_code';
        return $this->user->$column === $this->token;
    }
}
