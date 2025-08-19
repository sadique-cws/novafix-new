<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use App\Models\User;
use App\Models\Franchise;
use App\Models\Staff;
use App\Models\Receptioners;

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

        // Try all user types
        $userTypes = [
            'admin' => User::class,
            'franchise' => Franchise::class,
            'staff' => Staff::class,
            'receptioner' => Receptioners::class,
        ];

        foreach ($userTypes as $guard => $model) {
            $user = $model::where('email', $this->email)->first();
            
            if (!$user) {
                Log::debug("No user found for guard: $guard with email: {$this->email}");
                continue;
            }

            // Check password
            if (Hash::check($this->password, $user->password)) {
                // Check if the user is active (if applicable)
                if (property_exists($user, 'status') && $user->status !== 'active') {
                    $this->error = 'Your account is not active. Please contact administrator.';
                    Log::debug("User found but not active: {$user->id}");
                    return;
                }

                Log::debug("User found and password correct: {$user->id}, guard: $guard");
                
                // Use custom session login
                $this->customLogin($user, $guard);
                return $this->redirectToDashboard($guard);
            } else {
                Log::debug("Password incorrect for user: {$user->id}");
            }
        }

        $this->error = 'Invalid credentials. Please try again.';
        Log::debug("Login failed for email: {$this->email}");
    }

    private function customLogin($user, $guard)
    {
        // Store authentication details in session
        session([
            'authenticated' => true,
            'user_id' => $user->id,
            'user_type' => get_class($user),
            'guard' => $guard,
            'user_data' => $user->toArray() // Store user data for easy access
        ]);

        Log::debug("Session set for user: {$user->id}, guard: $guard");
    }

    private function redirectToDashboard($guard)
    {
        $routeName = "{$guard}.dashboard";
        
        // Check if the route exists before redirecting
        if (Route::has($routeName)) {
            Log::debug("Redirecting to: {$routeName}");
            return redirect()->route($routeName);
        } else {
            // Fallback to a generic dashboard or show an error
            Log::error("Route {$routeName} not defined");
            $this->error = "Dashboard route not configured. Please contact administrator.";
            return;
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}