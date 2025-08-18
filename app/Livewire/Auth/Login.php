<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

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

        // Determine guard based on user role
        $guard = $this->determineGuard($this->email);

        if (!$guard) {
            $this->error = 'No valid role found for this user';
            return;
        }

        if (Auth::guard($guard)->attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {
            return $this->redirectToDashboard(Auth::guard($guard)->user());
        }

        $this->error = 'Invalid credentials. Please try again.';
    }

    private function determineGuard($email)
    {
        // Find user by email to determine their role
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) return null;

        // Determine guard based on role flags
        if ($user->is_admin) return 'admin';
        if ($user->is_staff) return 'staff';
        if ($user->is_franchise) return 'franchise';
        if ($user->is_frontdesk) return 'frontdesk';
        
        return null;
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