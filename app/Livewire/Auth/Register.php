<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $error = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ];

    public function register()
    {
        $this->validate();
        $this->error = '';

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                // Default role for new registrations
                'is_frontdesk' => true,
            ]);

            // Log in with frontdesk guard
            Auth::guard('frontdesk')->login($user);
            return redirect()->route('frontdesk.dashboard');
            
        } catch (\Exception $e) {
            $this->error = 'Registration failed. Please try again.';
        }
    }


    public function render()
    {
        return view('livewire.auth.register');
    }
}