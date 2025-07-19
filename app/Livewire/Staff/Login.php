<?php

namespace App\Livewire\Staff;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

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

        if (Auth::guard('staff')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            $this->redirect('dashboard');
        }

        $this->error = 'Invalid email or password';
    }
    public function render()
    {
        return view('livewire.staff.login');
    }
}
