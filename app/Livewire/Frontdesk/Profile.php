<?php

namespace App\Livewire\Frontdesk;

use App\Models\Receptioners;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

#[Layout('components.layouts.frontdesk-layout')]
class Profile extends Component
{
    public Receptioners $receptionist;
    public bool $showPasswordModal = false;
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount()
    {
        $this->receptionist = Receptioners::findOrFail(Auth::guard('frontdesk')->user()->id);
    }

    public function togglePasswordModal()
    {
        $this->showPasswordModal = !$this->showPasswordModal;
        $this->reset([
            'current_password',
            'new_password',
            'new_password_confirmation'
        ]);
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password:frontdesk'],
            'new_password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        try {
            $this->receptionist->update([
                'password' => bcrypt($this->new_password)
            ]);

            $this->togglePasswordModal();
            $this->dispatch('notify', type: 'success', message: 'Password changed successfully!');
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Error changing password');
        }
    }

    public function render()
    {
        return view('livewire.frontdesk.profile');
    }
}
