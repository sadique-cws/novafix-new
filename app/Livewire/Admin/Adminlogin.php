<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public-layout')]
class Adminlogin extends Component
{
    public $email = '';
    public $password = '';
    public $error = '';

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

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            return $this->redirect(route('admin.dashboard'), navigate: true);
        }

        $this->error = 'Invalid email or password';
        $this->addError('email', 'Invalid credentials');
        $this->addError('password', 'Invalid credentials');
    }

    public function render()
    {
        return view('livewire.admin.adminlogin');
    }
}
