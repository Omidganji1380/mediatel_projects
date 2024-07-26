<?php

namespace App\Http\Livewire\Front\Panel\User\Profile;

use App\Events\ProfileEvent;
use App\Models\User;
use App\Notifications\User\SendVerifySms;
use App\Notifications\User\VerifyEmailNotification;
use App\Traits\Helper;
use Livewire\Component;

class VerifyEmail extends Component
{
    use Helper;

    public User $user;
    public $currentPage = 1;
    public $token;
    public $email;

    public $pages = [
        1 => [
            'heading' => 'Verify email Number',
            'subheading' => 'We will send a SMS to your provided email number.'
        ],
        2 => [
            'heading' => 'Verification Code',
            'subheading' => 'Enter the verification code that we sent to your email number.'
        ]
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->email = $user->email;
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.front.panel.user.profile.verify-email');
    }

    public function sendEmail()
    {
        $this->currentPage++;

        $this->user->update(['email_verify_code' => rand(11111, 99999)]);
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->user->notify(new VerifyEmailNotification);
    }

    public function verifyEmail()
    {
        $status = 'error';
        $message = __('messages.email_not_verified');
        if($this->token === $this->user->email_verify_code){
            $this->user->update(['email_verified_at' => now(), 'email_verify_code' => null]);
            $message = __('messages.email_verified');
            $status = 'success';
            $this->currentPage--;
            if($this->calculateRegistrationProgress() === 100){
                ProfileEvent::dispatch($this->user);
            }
        }

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => $status,
            'title' => $message,
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
        ]);
        $this->emit('progressUpdated');
    }

    public function previousPage()
    {
        $this->currentPage--;
    }
}
