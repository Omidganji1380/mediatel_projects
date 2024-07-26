<?php

namespace App\Http\Livewire\Front\Panel\User\Profile;

use App\Events\FreeSubscriptionEvent;
use App\Mail\Admins\AdminUpgradeLevelMail;
use App\Mail\User\UpgradeLevelMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Swift_TransportException;

class UpgradeAccessLevel extends Component
{
    public $roles;
    public $role;
    public $currentRole;
    public $lang;
    public $user;
    public $acceptRules;

    public function mount()
    {
        $this->lang = App::isLocale('fa') ? "" : "en.";
        $this->roles = User::FRONT_USER_ROLES;
        $this->role = auth()->user()->getRoleNames()->first();
        $this->user = auth()->user();
        $this->currentRole = $this->user->getRoleNames()->first();
    }

    public function render()
    {
        return view('livewire.front.panel.user.profile.upgrade-access-level');
    }

    public function submit()
    {
        $this->validate(
            [
                'role' => 'required|in:' . implode(",", array_keys(User::FRONT_USER_ROLES)),
                'acceptRules' => 'accepted',
            ],
            [
                'acceptRules.accepted' => __('validation.accept_rules'),
            ]
        );

        $this->changeRole($this->role);
    }

    public function changeRole(string $newRole)
    {
        $previousRole = __('messages.roles.' . auth()->user()->getRoleNames()->first());
        // if user has no subscription
        if(!$this->user->subscription){
            FreeSubscriptionEvent::dispatch($this->user);
        }
        // Check if the new role is "vip" and the current role is "customer"
        if ($newRole === 'vip' && !$this->user->subscription->plan?->vip) {
            // Redirect to the plans page
            return redirect()->to(route($this->lang . 'front.panel.user.plans.vip'));
        }

        // Check if the current role is one of the restricted roles
        if (in_array($this->currentRole, ['real_estate', 'business_owner', 'seller', 'property_applicant'])) {
            // Prevent changing to any role except "vip"
            if ($newRole !== 'vip') {
                // Redirect back or show an error message
                return $this->notification('error', __('messages.profile.upgrade_error'));
            }
        }

        // Handle other role changes here, if applicable
        // ...

        // If no redirection or restriction is needed, update the user's role
        $this->user->syncRoles($newRole);

        try {
            Mail::to($this->user->email)->queue(new UpgradeLevelMail($this->user));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }

        try {
            Mail::to('Kiusk.ca@yahoo.com')->queue(new AdminUpgradeLevelMail($this->user, $newRole, $previousRole));
            Mail::to('memoney026@gmail.com')->queue(new AdminUpgradeLevelMail($this->user, $newRole, $previousRole));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }
        // Redirect back or to a specific page
        $this->notification('success', __('messages.profile.upgraded_role'));
    }

    public function notification($icon, $text): void
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => $icon,
            'title' => $text,
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
        ]);
    }
}
