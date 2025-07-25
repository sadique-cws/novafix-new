<?php

namespace App\Livewire\Frontdesk;

use App\Models\Receptioners;
use App\Models\Receptionist;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

#[Layout('components.layouts.frontdesk-layout')]
class Profile extends Component
{
    use WithFileUploads;

    public Receptioners $receptionist;
    public bool $editing = false;
    public string $successMessage = '';
    public bool $showPasswordModal = false;
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';
    public $photo;
    public $tempPhotoUrl;

    protected function rules()
    {
        return [
            'receptionist.name' => 'required|string|max:255',
            'receptionist.contact' => 'required|digits:10',
            'receptionist.email' => 'required|email|unique:receptionists,email,' . Auth::id(),
            'receptionist.aadhar' => 'required|digits:12',
            'receptionist.pan' => 'required|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/',
            'receptionist.address' => 'required|string|max:500',
            'receptionist.salary' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    public function mount()
    {
        $this->receptionist = Receptioners::findOrFail(Auth::guard('frontdesk')->user()->id);
    }

    // Add this missing method
    public function togglePasswordModal()
    {
        $this->showPasswordModal = !$this->showPasswordModal;
        $this->resetPasswordFields();
    }

    public function resetPasswordFields()
    {
        $this->reset([
            'current_password',
            'new_password',
            'new_password_confirmation'
        ]);
    }

    public function startEditing()
    {
        $this->editing = true;
        $this->successMessage = '';
    }

    public function cancelEdit()
    {
        $this->receptionist->refresh();
        $this->editing = false;
        $this->photo = null;
        $this->tempPhotoUrl = null;
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->photo) {
                $photoPath = $this->photo->store('profile-photos', 'public');
                $this->receptionist->photo_path = $photoPath;
            }

            $this->receptionist->save();

            $this->editing = false;
            $this->photo = null;
            $this->tempPhotoUrl = null;
            $this->successMessage = 'Profile updated successfully!';
            $this->dispatch('notify', type: 'success', message: 'Profile updated!');
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Error updating profile: ' . $e->getMessage());
        }
    }

    public function updatedPhoto()
    {
        $this->validateOnly('photo');
        $this->tempPhotoUrl = $this->photo->temporaryUrl();
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
