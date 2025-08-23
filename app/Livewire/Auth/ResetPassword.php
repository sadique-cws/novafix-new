<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Staff;
use App\Models\Franchise;
use App\Models\Receptioners;

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;
    public $message = '';
    public $error = '';
    public $validToken = false;

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');

        // Validate token
        $this->validateToken();
    }

    protected function rules()
    {
        return [
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function validateToken()
    {
        $sessionKey = 'password_reset_' . $this->email;
        $resetData = session()->get($sessionKey);

        if (!$resetData) {
            $this->error = 'Invalid reset token.';
            return;
        }

        // Check if token is expired (60 minutes)
        $createdAt = Carbon::createFromTimestamp($resetData['created_at']);
        if ($createdAt->addMinutes(60)->isPast()) {
            $this->error = 'Reset token has expired.';
            session()->forget($sessionKey);
            return;
        }

        // Verify token
        if ($this->token !== $resetData['token']) {
            $this->error = 'Invalid reset token.';
            return;
        }

        $this->validToken = true;
    }

    public function resetPassword()
    {
        $this->validate();

        if (!$this->validToken) {
            $this->validateToken();
            return;
        }

        // Find user in appropriate table
        $user = $this->findUserByEmail($this->email);

        if (!$user) {
            $this->error = 'User not found.';
            return;
        }

        // Update password
        $user->password = Hash::make($this->password);
        $user->save();

        // Delete the reset token from session
        session()->forget('password_reset_' . $this->email);

        $this->message = 'Your password has been reset successfully!';

        // Redirect to login after a short delay
        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }

    private function findUserByEmail($email)
    {
        // Check all user tables
        if ($user = User::where('email', $email)->first()) {
            return $user;
        }

        if ($staff = Staff::where('email', $email)->first()) {
            return $staff;
        }

        if ($franchise = Franchise::where('email', $email)->first()) {
            return $franchise;
        }

        if ($receptioner = Receptioners::where('email', $email)->first()) {
            return $receptioner;
        }

        return null;
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
