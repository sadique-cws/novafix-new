<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Franchise;
use App\Models\franchises;
use App\Models\ServiceCategory;
use App\Models\Staff;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('staff profile')]
#[Layout('components.layouts.staff-layout')]

class Profile extends Component
{
    use WithFileUploads;

    // Personal Information
    public $name;
    public $email;
    public $contact;
    public $address;

    // Official Information
    public $franchise_id;
    public $service_categories_id;
    public $salary;
    public $status;

    // Documents
    public $aadhar;
    public $pan;
    public $image;
    public $currentImage;

    // Password
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Franchise and Service Categories
    public $franchises;
    public $serviceCategories;

    public function mount()
    {
        $staff = Auth::guard('staff')->user();

        // Personal Info
        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->contact = $staff->contact;
        $this->address = $staff->address;

        // Official Info
        $this->franchise_id = $staff->franchise_id;
        $this->service_categories_id = $staff->service_categories_id;
        $this->salary = $staff->salary;
        $this->status = $staff->status;

        // Documents
        $this->aadhar = $staff->aadhar;
        $this->pan = $staff->pan;
        $this->currentImage = $staff->image_url;

        // Load dropdown options
        $this->franchises = Franchise::all();
        $this->serviceCategories = ServiceCategory::all();
    }

    protected function rules()
    {
        return [
            // Personal Information
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . Auth::guard('staff')->id(),
            'contact' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',

            // Official Information
            'franchise_id' => 'nullable|exists:franchises,id',
            'service_categories_id' => 'nullable|exists:service_categories,id',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,on_leave',

            // Documents
            'aadhar' => 'nullable|string|size:12',
            'pan' => 'nullable|string|size:10',
            'image' => 'nullable|image|max:2048',

            // Password
            'current_password' => [
                'nullable',
                'required_with:new_password',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::guard('staff')->user()->password)) {
                        $fail('The current password is incorrect.');
                    }
                }
            ],
            'new_password' => [
                'nullable',
                'required_with:current_password',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ];
    }

    public function updateProfile()
    {
        $this->validate();

        $staff = Auth::guard('staff')->user();

        // Update basic info
        $staff->name = $this->name;
        $staff->email = $this->email;
        $staff->contact = $this->contact;
        $staff->address = $this->address;

        // Update official info
        $staff->franchise_id = $this->franchise_id;
        $staff->service_categories_id = $this->service_categories_id;
        $staff->salary = $this->salary;
        $staff->status = $this->status;

        // Update documents
        $staff->aadhar = $this->aadhar;
        $staff->pan = $this->pan;

        // Handle image upload
        if ($this->image) {
            // Delete old image if exists
            if ($staff->image) {
                Storage::disk('public')->delete($staff->image);
            }

            $path = $this->image->store('staff/images', 'public');
            $staff->image = $path;
        }

        // Update password if provided
        if ($this->new_password) {
            $staff->password = Hash::make($this->new_password);
        }


        // Refresh image display
        $this->currentImage = $staff->image_url; // Use the accessor
        $this->reset(['image', 'current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        $staff = Staff::all()->where('id', Auth::guard('staff')->id())->first();
        return view('livewire.staff.profile', [
            'staff' => $staff,
        ]);
    }
}
