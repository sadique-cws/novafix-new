<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
   public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'admin';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:frontdesk,franchise,staff,admin',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => $this->role === 'admin',
            'is_staff' => $this->role === 'staff',
            'is_franchise' => $this->role === 'franchise',
            'is_frontdesk' => $this->role === 'frontdesk',
        ]);

        Auth::login($user);

        // Redirect based on role
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->is_staff) {
            return redirect()->route('staff.dashboard');
        } elseif ($user->is_franchise) {
            return redirect()->route('franchise.dashboard');
        } else {
            return redirect()->route('frontdesk.dashboard');
        }
    }
    // private function redirectToDashboard($user)
    // {
    //     if ($user->is_admin) {
    //         return redirect()->route('admin.dashboard');
    //     } elseif ($user->is_staff) {
    //         return redirect()->route('staff.dashboard');
    //     } elseif ($user->is_franchise) {
    //         return redirect()->route('franchise.dashboard');
    //     } elseif ($user->is_frontdesk) {
    //         return redirect()->route('frontdesk.dashboard');
    //     }
        
    //     return redirect('/');
    // }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
