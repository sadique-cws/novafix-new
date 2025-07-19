<?php

namespace App\Livewire\Frontdesk;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public-layout')]
class FrontDeskLogin extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.frontdesk.front-desk-login');
    }

    public function login()
    {
        $this->validate();

        if (!Auth::guard('frontdesk')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return redirect()->route('frontdesk.dashboard');
    }

    // If you want to show/hide password functionality in Livewire
    public $showPassword = false;

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }
}
