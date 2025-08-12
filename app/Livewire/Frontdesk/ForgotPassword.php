<?php

namespace App\Livewire\Frontdesk;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public-layout')]
class ForgotPassword extends Component
{
    public $email;
    public $emailSent = false;
    public $error = null;

    protected $rules = [
        'email' => 'required|email',
    ];
    //   |unique:receptioners,email
    public function render()
    {
        return view('livewire.frontdesk.forgot-password');
    }

    public function sendResetLink()
    {
        $this->validate(['email' => 'required|email']);

        $status = Password::broker('receptioners')->sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->emailSent = true;
        } else {
            $this->error = __($status);
        }
    }
}
