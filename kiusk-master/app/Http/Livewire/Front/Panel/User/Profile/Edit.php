<?php

namespace App\Http\Livewire\Front\Panel\User\Profile;

use App\Events\ProfileEvent;
use App\Http\Livewire\Front\Panel\User\Profile\Edit\Media;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use Media;
    use Helper;

    protected $listeners = ['progressUpdated'];

    public User $user;
    public $password = '';
    public $newPassword = '';
    public $newPassword_confirmation = '';
    public $registrationProgress;
    public $send_code_via_telegram;
    public $notCompleteItems = [];

    protected function rules()
    {
        return [
            'user.name' => '',
            'user.phone' => 'required|numeric',
            'user.first_name' => 'required|min:3',
            'user.last_name' => 'required|min:3',
            'user.address' => 'nullable|min:3',
            'user.description' => 'nullable|min:3',
            'user.email' => 'required|email',
            'user.email' => 'required|email',
            'user.send_code_via_telegram' => 'nullable|boolean',
            'password' => 'current_password',
            'newPassword' => [
                'confirmed',
                'required_with:password',
                Password::defaults(),
            ],
            'newPassword_confirmation' => 'required_with:password,newPassword',
        ];
    }

    protected $validationAttributes = [
        'email' => 'ایمیل',
        'name' => 'نام نمایشی',
        'password' => 'گذرواژه پیشین',
        'newPassword' => 'گذرواژه جدید',
        'newPassword_confirmation' => 'تکرار گذرواژه جدید',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->user = $user;
        $this->previewAvatar = $user?->getFirstMedia('profile')?->getUrl();
        $this->registrationProgress = $this->calculateRegistrationProgress();
        $this->notCompletedItems();
    }

    /**
     * Calcualte the the percentage of the regisration progress
     *
     * @param User $user
     * @return integer
     */
    public function notCompletedItems()
    {
        $this->notCompleteItems = [];
        $user = auth()->user();
        $user->refresh();
        $properties = User::REGISTRATION_PROGRESS;
        foreach ($properties as $key => $value) {
            if (!$user->$key) {
                $this->notCompleteItems[] = $key;
            }
        }
    }

    //
    // public function updatedUserName()
    // {
    //  $this->validate(['user.name' => $this->user->name], [
    //   'user.name' => [
    //    'required',
    //    'min:3',
    //    Rule::unique('users', 'name')
    //        ->ignore(auth()->id()),
    //   ]
    //  ],              $this->validationAttributes);
    // }
    public function store()
    {
        $this->validationAll();
        $user = $this->user;
        if ($this->newPassword) {
            $user->password = bcrypt($this->newPassword);
        }
        $user->update($user->attributesToArray());
        if (count($user->getChanges())) {
            if($user->wasChanged('email')){
                $user->update(['email_verified_at' => null]);
            }
            if($user->wasChanged('phone')){
                $user->update([
                    'country_code' => '+1',
                    'phone_verified_at' => null
                ]);
            }
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => __('messages.profile.edit'),
                'timerProgressBar' => true,
                'timer' => 20000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300,
            ]);

            $this->registrationProgress = $this->calculateRegistrationProgress();
            $this->dispatchBrowserEvent('progressUpdated');
            $this->notCompletedItems();
            if($this->calculateRegistrationProgress() === 100){
                ProfileEvent::dispatch($user);
            }
        }
    }

    public function progressUpdated()
    {
        $this->notCompletedItems();
        $this->registrationProgress = $this->calculateRegistrationProgress();
        $this->dispatchBrowserEvent('progressUpdated');
    }

    public function render()
    {
        return view('livewire.front.panel.user.profile.edit');
    }

    public function validationAll()
    {
        $rules = self::rules();
        $rules['user.name'] = [
            'required',
            'min:3',
            Rule::unique('users', 'name')
                ->ignore(auth()->id()),
        ];
        $rules['user.email'] = [
            'required',
            'min:3',
            Rule::unique('users', 'email')
                ->ignore(auth()->id()),
        ];
        $rules['user.phone'] = [
            'required',
            'regex:/^[1-9][0-9]*$/',
            Rule::unique('users', 'phone')
                ->ignore(auth()->id()),
        ];

        return $this->validate($rules, [], $this->validationAttributes);
    }
}
