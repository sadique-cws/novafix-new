<?php

// app/Livewire/Auth/ResetPassword.php
namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;
    public $success = false;
    public $error = '';

    public function mount($token)
    {
        $this->token = $token;
    }

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ];

    public function resetPassword()
    {
        $this->validate();
        $this->error = '';

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
                
                $this->success = true;
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            $this->error = __($status);
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
