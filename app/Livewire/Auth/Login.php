<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\User;
use App\Models\Staff;
use App\Models\Franchise;
use App\Models\Receptioners;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Title('login page')]


class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public $error = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:5',
    ];

   public function login()
{
    $this->validate();
    $this->error = '';
    
    \Log::debug('Login attempt started', ['email' => $this->email]);

    // Try to find the account across different models (staff, receptioners, franchise, users)
    $found = null;
    $guard = null;

    // Prefer dedicated tables first
    $staff = Staff::where('email', $this->email)->first();
    if ($staff) {
        $found = $staff;
        $guard = 'staff';
    }

    if (!$found) {
        $receptioner = Receptioners::where('email', $this->email)->first();
        if ($receptioner) {
            $found = $receptioner;
            // use the frontdesk guard which maps to receptioners provider
            $guard = 'frontdesk';
        }
    }

    if (!$found) {
        $franchise = Franchise::where('email', $this->email)->first();
        if ($franchise) {
            $found = $franchise;
            $guard = 'franchise';
        }
    }

    if (!$found) {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            $found = $user;
            // For entries in users table only map to admin or frontdesk (others have dedicated tables)
            if ($user->is_admin) {
                $guard = 'admin';
            } elseif ($user->is_frontdesk) {
                $guard = 'frontdesk';
            } else {
                $guard = 'web';
            }
        }
    }

    if (!$found) {
        \Log::error('Login failed: No account found for email', ['email' => $this->email]);
        $this->error = 'Invalid credentials. Please try again.';
        return;
    }

    // Verify password
    if (!Hash::check($this->password, $found->password)) {
        \Log::warning('Password verification failed', ['email' => $this->email, 'guard' => $guard]);
        $this->error = 'Invalid credentials. Please try again.';
        return;
    }

    // Log the user in for the correct guard
    try {
        Auth::guard($guard)->login($found, $this->remember);
    } catch (\Throwable $e) {
        \Log::error('Guard login failed', ['guard' => $guard, 'email' => $this->email, 'exception' => $e->getMessage()]);
        $this->error = 'Authentication error. Please try again.';
        return;
    }

    \Log::info('Login successful', ['guard' => $guard, 'user_id' => $found->id]);

    return $this->redirectToDashboard(Auth::guard($guard)->user());
}

    private function redirectToDashboard($user)
    {
        // $user may be an instance of Staff, Franchise, Receptioners or User
        if ($user instanceof \App\Models\Staff) {
            return redirect()->route('staff.dashboard');
        }

        if ($user instanceof \App\Models\Franchise) {
            return redirect()->route('franchise.dashboard');
        }

        if ($user instanceof \App\Models\Receptioners) {
            return redirect()->route('frontdesk.dashboard');
        }

        // fallback to User flags (admin/frontdesk)
        if (isset($user->is_admin) && $user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        if (isset($user->is_frontdesk) && $user->is_frontdesk) {
            return redirect()->route('frontdesk.dashboard');
        }
        
        // Default logout if no role matches
        Auth::logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}