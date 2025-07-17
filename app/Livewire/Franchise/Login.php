<?php

namespace App\Livewire\Franchise;

use App\Models\franchises;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public-layout')]
class Login extends Component
{

    public $email;
    public $password;
    public $error;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    public function login()
    {
        $this->validate();

        if (Auth::guard('franchise')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            return redirect()->route('franchise.dashboard');
        }

        $this->error = 'Invalid email or password';
    }

    public function render()
    {
        return view('livewire.franchise.login');
    }
}
