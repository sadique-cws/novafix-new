<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
#[Title('Register')]

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role = 'frontdesk'; // Default role
    public $error = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:staff,franchise,frontdesk',
    ];

    // public function register()
    // {
    //     $this->validate();
    //     $this->error = '';

    //     try {
    //         $user = User::create([
    //             'name' => $this->name,
    //             'email' => $this->email,
    //             'password' => Hash::make($this->password),
    //             'role' => $this->role, // Save selected role
    //         ]);

    //         // Log in with role-specific guard
    //         Auth::guard($this->role)->login($user);
            
    //         // Redirect to role-specific dashboard
    //         return redirect()->route("{$this->role}.dashboard");
            
    //     } catch (\Exception $e) {
    //         $this->error = 'Registration failed. Please try again.';
    //     }
    // }

    public function register()
{
    $this->validate();
    $this->error = '';

    try {
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ];

        // Set both role column and boolean flags
        if ($this->role === 'staff') {
            $userData['is_staff'] = true;
        } elseif ($this->role === 'franchise') {
            $userData['is_franchise'] = true;
        } elseif ($this->role === 'frontdesk') {
            $userData['is_frontdesk'] = true;
        }

        $user = User::create($userData);

        // Log in with the specific guard
        Auth::guard($this->role)->login($user);
        
        // Redirect to role-specific dashboard
        return redirect()->route("{$this->role}.dashboard");
        
    } catch (\Exception $e) {
        $this->error = 'Registration failed. Please try again.';
    }
}

    public function render()
    {
        return view('livewire.auth.register');
    }
}