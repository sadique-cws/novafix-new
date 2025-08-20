<?php

namespace App\Livewire\Franchise;

use App\Models\Franchise;
use App\Models\Receptioners;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Title('Add Receptionist')]
#[Layout('components.layouts.franchise-layout')]
class AddReceptioners extends Component
{
    public $franchise_id;
    public $name;
    public $contact;
    public $email;
    public $aadhar;
    public $pan;
    public $address;
    public $salary;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'franchise_id' => 'nullable|exists:franchises,id',
        'name' => 'required|string|max:255',
        'contact' => 'required|string|max:15|unique:receptioners,contact',
        'email' => 'required|email|unique:receptioners,email',
        'aadhar' => 'required|string|size:12|unique:receptioners,aadhar',
        'pan' => 'required|string|size:10|unique:receptioners,pan',
        'address' => 'required|string|max:500',
        'salary' => 'required|numeric',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function render()
    {
        return view('livewire.franchise.add-receptioners');
    }

    public function save()
    {
        $this->validate();

        Receptioners::create([
            'franchise_id' => Auth::guard('franchise')->user()->id,
            'name' => $this->name,
            'contact' => $this->contact,
            'email' => $this->email,
            'aadhar' => $this->aadhar,
            'pan' => $this->pan,
            'address' => $this->address,
            'salary' => $this->salary,
            'password' => Hash::make($this->password),
            'status' => 1,
        ]);

        session()->flash('success', 'Receptionist added successfully!');
        $this->redirect('manage-receptioners', navigate: true);
    }
   
}
