<?php

namespace App\Livewire\Auth;

use App\Models\Franchise;
use App\Models\Receptioners;
use App\Models\Staff;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;
    public $message = '';
    public $error = '';

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    protected function rules()
    {
        return [
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function resetPassword()
    {
        $this->validate();
        $this->error = '';
        $this->message = '';

        $broker = $this->resolveBrokerByEmail($this->email);
        if (!$broker) {
            $this->error = 'Invalid or expired reset token.';
            return;
        }

        $status = Password::broker($broker)->reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            $this->error = 'Invalid or expired reset token.';
            return;
        }

        return redirect()->route('login')->with('status', 'Password reset successfully!');
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
        return view('livewire.auth.reset-password');
    }
}
