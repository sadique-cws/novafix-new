<?php

namespace App\Livewire\Franchise;

use App\Models\ServiceCategory;
use App\Models\Staff;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Staff Edit')]
#[Layout('components.layouts.franchise-layout')]

class StaffEdit extends Component
{
    use WithFileUploads;

    public Staff $staff;
    public $isUpdating = false;
    public $image;

    // Form fields
    public $name;
    public $email;
    public $contact;
    public $salary;
    public $service_categories_id;
    public $status;
    public $aadhar;
    public $pan;
    public $address;

    public function mount($id)
    {
        $this->staff = Staff::findOrFail($id);
        $this->loadStaffData();
    }

    public function loadStaffData()
    {
        $this->name = $this->staff->name;
        $this->email = $this->staff->email;
        $this->contact = $this->staff->contact;
        $this->salary = $this->staff->salary;
        $this->service_categories_id = $this->staff->service_categories_id;
        $this->status = $this->staff->status;
        $this->aadhar = $this->staff->aadhar;
        $this->pan = $this->staff->pan;
        $this->address = $this->staff->address;
    }

    public function updateStaff()
    {
        $this->isUpdating = true;

        try {
            $validatedData = $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:staff,email,' . $this->staff->id,
                'contact' => 'required|string|max:15',
                'salary' => 'required|numeric',
                'service_categories_id' => 'required|exists:service_categories,id',
                'status' => 'required|string',
                'aadhar' => 'required|string|max:20',
                'pan' => 'required|string|max:20',
                'address' => 'required|string',
                'image' => 'nullable|image|max:2048',
            ]);

            if ($this->image) {
                $validatedData['image'] = $this->image->store('staff', 'public');
            }

            $this->staff->update($validatedData);

            session()->flash('success', 'Staff updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating staff: ' . $e->getMessage());
        } finally {
            $this->isUpdating = false;
        }
    }

    public function render()
    {
        return view('livewire.franchise.staff-edit', [
            'serviceCategories' => ServiceCategory::all()
        ]);
    }
}
