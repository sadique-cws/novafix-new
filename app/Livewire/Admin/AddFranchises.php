<?php

namespace App\Livewire\Admin;

use App\Models\franchises;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AddFranchises extends Component
{
    public $franchise_name;
    public $contact_no;
    public $email;
    public $password;
    public $password_confirmation;
    public $aadhar_no;
    public $pan_no;
    public $ifsc_code;
    public $bank_name;
    public $account_no;
    public $street;
    public $city;
    public $district;
    public $pincode;
    public $state;
    public $country;
    public $doc;
    public $sortField = 'created_at';

    public $status = 'pending';

    protected $rules = [
        'franchise_name' => 'required|min:3',
        'contact_no' => 'required|digits:10',
        'email' => 'required|email|unique:franchises,email',
        'password' => 'required|min:8|confirmed',
        'aadhar_no' => 'nullable|digits:12',
        'pan_no' => 'nullable|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/',
        'ifsc_code' => 'nullable|regex:/^[A-Za-z]{4}[a-zA-Z0-9]{7}$/',
        'bank_name' => 'nullable|string|max:255',
        'account_no' => 'nullable|digits_between:9,18',
        'street' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'district' => 'nullable|string|max:255',
        'pincode' => 'nullable|digits:6',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'doc' => 'nullable|date',
        'status' => 'required|in:active,inactive,pending',
    ];

    public function submit()
    {
        $this->validate();

        franchises::create([
            'franchise_name' => $this->franchise_name,
            'contact_no' => $this->contact_no,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'aadhar_no' => $this->aadhar_no,
            'pan_no' => $this->pan_no,
            'ifsc_code' => $this->ifsc_code,
            'bank_name' => $this->bank_name,
            'account_no' => $this->account_no,
            'street' => $this->street,
            'city' => $this->city,
            'district' => $this->district,
            'pincode' => $this->pincode,
            'state' => $this->state,
            'country' => $this->country,
            'doc' => $this->doc,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Franchise created successfully.');
        return redirect()->route('admin.manage-franchises'); // Change to your desired route
    }
    public function render()
    {
        return view('livewire.admin.add-franchises');
    }
}
