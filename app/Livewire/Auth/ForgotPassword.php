<?php

namespace App\Livewire\Auth;

use App\Models\Franchise;
use App\Models\Receptioners;
use App\Models\Staff;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Component
{
    public $email;
    public $message = '';
    public $error = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendResetLink()
    {
        $this->validate();
        $this->error = '';
        $this->message = '';
        $broker = $this->resolveBrokerByEmail($this->email);

        if ($broker) {
            try {
                Password::broker($broker)->sendResetLink(['email' => $this->email]);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // Always return a generic message to prevent account enumeration.
        $this->message = 'If your email exists in our system, you will receive a password reset link shortly.';
    }

    private function resolveBrokerByEmail(string $email): ?string
    {
        if (Staff::where('email', $email)->exists()) {
            return 'staff';
        }

        if (Receptioners::where('email', $email)->exists()) {
            return 'receptioners';
        }

        if (Franchise::where('email', $email)->exists()) {
            return 'franchises';
        }

        if (User::where('email', $email)->exists()) {
            return 'users';
        }

        return null;
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
