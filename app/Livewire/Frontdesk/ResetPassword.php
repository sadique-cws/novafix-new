<?php

namespace App\Livewire\Frontdesk;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public-layout')]
class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function render()
    {
        return view('livewire.frontdesk.reset-password');
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'The password field is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Passwords do not match',
        ]);

        $status = Password::broker('receptioners')->reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Your password has been reset successfully! You can now login with your new password.');
            return redirect()->route('frontdesk.login');
        } else {
            $this->addError('email', 'This password reset token is invalid or has expired. Please request a new reset link.');
        }
    }
}