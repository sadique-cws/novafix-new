<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use App\Models\franchises;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

#[Title('Edit Franchise')]
#[Layout('components.layouts.admin-layout')]
class EditFranchise extends Component
{
    public $franchise;
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
    public $status;

    public function mount($id)
    {
        $this->franchise = Franchise::findOrFail($id);

        // Set all the properties from the franchise model
        $this->franchise_name = $this->franchise->franchise_name;
        $this->contact_no = $this->franchise->contact_no;
        $this->email = $this->franchise->email;
        $this->aadhar_no = $this->franchise->aadhar_no;
        $this->pan_no = $this->franchise->pan_no;
        $this->ifsc_code = $this->franchise->ifsc_code;
        $this->bank_name = $this->franchise->bank_name;
        $this->account_no = $this->franchise->account_no;
        $this->street = $this->franchise->street;
        $this->city = $this->franchise->city;
        $this->district = $this->franchise->district;
        $this->pincode = $this->franchise->pincode;
        $this->state = $this->franchise->state;
        $this->country = $this->franchise->country;
        $this->doc = $this->franchise->doc;
        $this->status = $this->franchise->status;
    }

    protected $rules = [
        'franchise_name' => 'required|min:3|max:255',
        'contact_no' => 'required|digits:10|unique:franchises,contact_no,',
        'email' => 'required|email|unique:franchises,email,',
        'password' => 'nullable|min:8|confirmed',
        'aadhar_no' => 'nullable|digits:12|unique:franchises,aadhar_no,',
        'pan_no' => 'nullable|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/|unique:franchises,pan_no,',
        'ifsc_code' => 'nullable|regex:/^[A-Za-z]{4}[a-zA-Z0-9]{7}$/',
        'bank_name' => 'nullable|string|max:255',
        'account_no' => 'nullable|digits_between:9,18|unique:franchises,account_no,',
        'street' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'district' => 'nullable|string|max:255',
        'pincode' => 'nullable|digits:6',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'doc' => 'nullable|date',
        'status' => 'required|in:active,inactive,pending',
    ];

    protected function rules()
    {
        return [
            'franchise_name' => 'required|min:3|max:255',
            'contact_no' => 'required|digits:10|unique:franchises,contact_no,' . $this->franchise->id,
            'email' => 'required|email|unique:franchises,email,' . $this->franchise->id,
            'password' => 'nullable|min:8|confirmed',
            'aadhar_no' => 'nullable|digits:12|unique:franchises,aadhar_no,' . $this->franchise->id,
            'pan_no' => 'nullable|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/|unique:franchises,pan_no,' . $this->franchise->id,
            'ifsc_code' => 'nullable|regex:/^[A-Za-z]{4}[a-zA-Z0-9]{7}$/',
            'bank_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|digits_between:9,18|unique:franchises,account_no,' . $this->franchise->id,
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'pincode' => 'nullable|digits:6',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'doc' => 'nullable|date',
            'status' => 'required|in:active,inactive,pending',
        ];
    }

    protected $messages = [
        'contact_no.digits' => 'Contact number must be 10 digits',
        'aadhar_no.digits' => 'Aadhar number must be 12 digits',
        'pan_no.regex' => 'Invalid PAN number format',
        'ifsc_code.regex' => 'Invalid IFSC code format',
        'pincode.digits' => 'Pincode must be 6 digits',
    ];

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $updateData = [
                'franchise_name' => $this->franchise_name,
                'contact_no' => $this->contact_no,
                'email' => $this->email,
                'status' => $this->status,
            ];

            // Only update fields that are not null
            $optionalFields = [
                'aadhar_no',
                'pan_no',
                'ifsc_code',
                'bank_name',
                'account_no',
                'street',
                'city',
                'district',
                'pincode',
                'state',
                'country',
                'doc'
            ];

            foreach ($optionalFields as $field) {
                if (!is_null($this->$field)) {
                    $updateData[$field] = $this->$field;
                }
            }

            // Only update password if it's provided
            if ($this->password) {
                $updateData['password'] = Hash::make($this->password);
            }

            $this->franchise->update($updateData);

            DB::commit();

            session()->flash('success', 'Franchise updated successfully.');
            return redirect()->route('admin.manage-franchises');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Franchise update failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update franchise. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admin.edit-franchise');
    }
}
