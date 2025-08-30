<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class Setting extends Component
{
    public $name;
    public $email;
    public $admin;

    public $currentPassword;
    public $newPassword;
    public $newPassword_confirmation; // Add this property
    public function mount()
    {
        $this->admin = User::where('is_admin', 1)
            ->first();
        $this->name = $this->admin->name;
        $this->email = $this->admin->email;

    }
    public function updateName()
    {
        $this->validate([
            'name' => 'required|string'
        ]);
        $this->admin->update([
            'name' => $this->name,
        ]);

        session()->flash( 'message','Admin name updated successfully');
    }

    public function changePassword(){
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:6',
            'newPassword_confirmation' => 'required|min:6|same:newPassword_confirmation',
        ],[
            'newPassword.same' => 'Passwords do not match',
        ]);

        $admin = User::where('is_admin',1)->first();

        if(!Hash::check($this->currentPassword, $admin->password)){
            $this->addError('currentPassword','Current Password is incorrect');
            return;
        }

        // Actually update the password
        $admin->update([
            'password' => Hash::make($this->newPassword),
        ]);

        $this->reset(['currentPassword','newPassword','newPassword_confirmation']);

        session()->flash('message','Password updated Successfully');
    }
    public function render()
    {
        return view('livewire.admin.setting');
    }
}
