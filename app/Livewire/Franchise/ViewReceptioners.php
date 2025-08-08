<?php

namespace App\Livewire\Franchise;

use App\Models\Receptioners;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.franchise-layout')]
class ViewReceptioners extends Component
{
    public Receptioners $receptionist;
    public $showEditModal = false;
    public $isUpdating = false; // Add this property
    public $active = false; // Add this property
    public $inactive = false; // Add this property

    // Form fields
    public $name;
    public $email;
    public $contact;
    public $aadhar;
    public $pan;
    public $address;
    public $salary;
    public $status;

    public function mount($id)
    {
        $this->receptionist = Receptioners::findOrFail($id);
        $this->loadReceptionistData();
    }

    public function loadReceptionistData()
    {
        $this->name = $this->receptionist->name;
        $this->email = $this->receptionist->email;
        $this->contact = $this->receptionist->contact;
        $this->aadhar = $this->receptionist->aadhar;
        $this->pan = $this->receptionist->pan;
        $this->address = $this->receptionist->address;
        $this->salary = $this->receptionist->salary;
        $this->status = $this->receptionist->status;
    }

    public function updateReceptionist()
    {
        $this->isUpdating = true; // Show loader

        try {
            $validatedData = $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:receptioners,email,' . $this->receptionist->id,
                'contact' => 'required|string|max:15',
                'aadhar' => 'required|string|max:20',
                'pan' => 'required|string|max:20',
                'address' => 'required|string',
                'salary' => 'required|numeric|min:0',
                'status' => 'required|boolean',
            ]);

            $this->receptionist->update($validatedData);

            session()->flash('success', 'Receptionist updated successfully!');
        } finally {
            $this->isUpdating = false; // Hide loader
            $this->showEditModal = false;
        }
    }
    public function openEditModal()
    {
        $this->showEditModal = true;
    }

    public function render()
    {
        return view('livewire.franchise.view-receptioners');
    }
}
