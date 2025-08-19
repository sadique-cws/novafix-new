<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Component
{
    public $email;
    public $success = false;
    public $error = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendResetLink()
    {
        $this->validate();
        $this->error = '';
        $this->success = false;

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->success = true;
            return;
        }

        $this->error = __($status);
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}