<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {
            
            return $this->redirectToDashboard(auth()->user());
        }

        session()->flash('error', 'Invalid credentials. Please try again.');
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
