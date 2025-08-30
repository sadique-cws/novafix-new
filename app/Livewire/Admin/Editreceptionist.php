<?php

namespace App\Livewire\Admin;

use App\Models\Receptioners;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class Editreceptionist extends Component
{
    public $receptionist;

    public $name, $contact, $email, $aadhar, $pan, $address, $salary, $status, $franchise_id;

    public function mount($id)
    {
        $this->receptionist = Receptioners::findOrFail($id);

        // Fill properties with DB values
        $this->franchise_id = $this->receptionist->franchise_id;
        $this->name         = $this->receptionist->name;
        $this->contact      = $this->receptionist->contact;
        $this->email        = $this->receptionist->email;
        $this->aadhar       = $this->receptionist->aadhar;
        $this->pan          = $this->receptionist->pan;
        $this->address      = $this->receptionist->address;
        $this->salary       = $this->receptionist->salary;
        $this->status       = $this->receptionist->status;
    }

    public function update()
    {
        $this->validate([
            'name'       => 'required|string|max:255',
            'contact'    => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'aadhar'     => 'required|string|max:255',
            'pan'        => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'salary'     => 'required|string|max:255',
            'status'     => 'required|string|max:255',
            'franchise_id' => 'nullable|integer',
        ]);

        $this->receptionist->update([
            'name'         => $this->name,
            'contact'      => $this->contact,
            'email'        => $this->email,
            'aadhar'       => $this->aadhar,
            'pan'          => $this->pan,
            'address'      => $this->address,
            'salary'       => $this->salary,
            'status'       => $this->status,
        ]);

        session()->flash('success', 'Receptionist updated successfully!');
    }    public function render()
    {
        return view('livewire.admin.editreceptionist');
    }
}
