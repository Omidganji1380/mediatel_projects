<?php

namespace App\Http\Livewire\Front\Panel\User\Profile;

use App\Events\ProfileEvent;
use App\Models\User;
use App\Notifications\User\SendVerifySms;
use App\Notifications\User\VerifyEmailNotification;
use App\Traits\Helper;
use Livewire\Component;

class VerifyPhone extends Component
{
    use Helper;

    public User $user;
    public $currentPage = 1;
    public $token;
    public $phone;

    public $pages = [
        1 => [
            'heading' => 'Verify Phone Number',
            'subheading' => 'We will send a SMS to your provided phone number.'
        ],
        2 => [
            'heading' => 'Verification Code',
            'subheading' => 'Enter the verification code that we sent to your phone number.'
        ]
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->phone = $user->phone;
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.front.panel.user.profile.verify-phone');
    }

    public function sendSms()
    {
        $this->currentPage++;

        $this->user->update(['phone_verify_code' => rand(11111, 99999)]);

        $this->user->notify(new SendVerifySms);

        // $this->user()->notify(NotificationsVerifyEmail::toMailUsing(function ($notifiable) {
        //         return (new MailMessage)
        //             ->subject('Verify Email Address')
        //             ->line('Click the button below to verify your email address.')
        //             ->action('Verify Email Address', route('front.panel.user.profile.edit'));
        //     })
        // );
    }

    public function verifySms()
    {
        $status = 'error';
        $message = __('messages.phone_not_verified');
        if($this->token === $this->user->phone_verify_code){
            $this->user->update(['phone_verified_at' => now(), 'phone_verify_code' => null]);
            $message = __('messages.phone_verified');
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
        $this->dispatchBrowserEvent('progressUpdated');
    }

    public function previousPage()
    {
        $this->currentPage--;
    }
}
