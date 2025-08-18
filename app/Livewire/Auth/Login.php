<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public $error = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();
        $this->error = '';

        // Find user by email
        $user = User::where('email', $this->email)->first();

        // Verify credentials and role
        if (!$user || !Hash::check($this->password, $user->password)) {
            $this->error = 'Invalid credentials. Please try again.';
            return;
        }

        // Determine guard based on user role
        $guard = $this->getGuardForUser($user);

        // Attempt authentication with the specific guard
        if (Auth::guard($guard)->attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {
            return $this->redirectToDashboard($user);
        }

        $this->error = 'Authentication failed. Please try again.';
    }

    private function getGuardForUser($user)
    {
        if ($user->is_admin) {
            return 'admin';
        } elseif ($user->is_staff) {
            return 'staff';
        } elseif ($user->is_franchise) {
            return 'franchise';
        } elseif ($user->is_frontdesk) {
            return 'frontdesk';
        }
        
        return 'web';
    }

    private function redirectToDashboard($user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->is_staff) {
            return redirect()->route('staff.dashboard');
        } elseif ($user->is_franchise) {
            return redirect()->route('franchise.dashboard');
        } elseif ($user->is_frontdesk) {
            return redirect()->route('frontdesk.dashboard');
        }
        
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}