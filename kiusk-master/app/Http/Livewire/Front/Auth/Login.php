<?php

namespace App\Http\Livewire\Front\Auth;

use App\Models\User;
use Livewire\Component;

class Login extends Component
{
    protected $listeners = ['toggleFormLogin'];
    public bool $showForm = true;
    public $username;
    public $password;
    public $remember;
    protected $rules = [
        'username' => 'required',
        'password' => 'required',
    ];
    protected $validationAttributes = [
        'username' => 'ایمیل یا شماره موبایل'
    ];

    public function authUser()
    {
        $columnName = $this->getColumnName();
        if (auth()->attempt([
            $columnName => $this->username,
            'password' => $this->password,
        ], $this->remember)) {
            request()
                ->session()
                ->regenerate();
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => __('messages.login_success'),
                'timerProgressBar' => true,
                'timer' => 1000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300
            ]);
            //   return redirect()->route('front.panel.user.ad.index');
            return redirect()->intended(route('front.panel.user.ad.index'));
        }
        $this->addError('all', __('messages.login_error'));
        //  return back()->withErrors([
        //                             'email' => 'The provided credentials do not match our records.',
        //                            ]);
    }

    public function render()
    {
        return view('livewire.front.auth.login');
    }

    protected function getColumnName(): string
    {
        $this->validate();
        $columnName = \Validator::make(['username' => $this->username], [
            'username' => 'email',
        ])
            ->passes() ? 'email' : 'phone';
        return $columnName;
    }

    public function toggleFormLogin()
    {
        $this->showForm = !$this->showForm;
    }

    public function forget()
    {
        $this->emit('toggleFormForgetPassword');
        $this->toggleFormLogin();
    }
}
