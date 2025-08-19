<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

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

        if (!$user) {
            $this->error = 'Invalid credentials. Please try again.';
            return;
        }

        // Determine the guard based on user's role
        $guard = $this->determineGuard($user);

        if (!$guard) {
            $this->error = 'No valid role found for this user';
            return;
        }

        // Attempt login with the specific guard
        if (Auth::guard($guard)->attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {
            return $this->redirectToDashboard($user, $guard);
        }

        $this->error = 'Invalid credentials. Please try again.';
    }

    private function determineGuard($user)
    {
        // First check if role column exists and is set
        if (isset($user->role) && !empty($user->role)) {
            return $user->role;
        }
        
        // Fallback to boolean flags
        if ($user->is_admin) return 'admin';
        if ($user->is_staff) return 'staff';
        if ($user->is_franchise) return 'franchise';
        if ($user->is_frontdesk) return 'frontdesk';
        
        return null;
    }

    private function redirectToDashboard($user, $guard)
    {
        // Redirect using the guard name
        return redirect()->route("{$guard}.dashboard");
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}