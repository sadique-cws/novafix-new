<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.franchise-layout')]

class FranchiseProfile extends Component
{
    public $franchise;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public $showChangePasswordModal = false;

    public function mount()
    {
        $this->franchise = Auth::user(); // load logged-in franchise details
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($this->current_password, $this->franchise->password)) {
            $this->addError('current_password', 'Your current password is incorrect.');
            return;
        }

        $this->franchise->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Reset inputs & close modal
        $this->reset(['current_password', 'new_password', 'new_password_confirmation', 'showChangePasswordModal']);
        session()->flash('success', 'Password changed successfully.');
    }


    public function render()
    {
        return view('livewire.franchise.franchise-profile');
    }
}
