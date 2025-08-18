<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.admin-layout')]
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
    public $country = 'India'; // Default to India
    public $doc;
    public $status = 'active';

    protected $rules = [
        'franchise_name' => 'required|min:3|max:255',
        'contact_no' => 'required|digits:10|unique:franchises,contact_no',
        'email' => 'required|email|unique:franchises,email',
        'password' => 'required|min:8|confirmed',
        'aadhar_no' => 'nullable|digits:12|unique:franchises,aadhar_no',
        'pan_no' => 'nullable|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/|unique:franchises,pan_no',
        'ifsc_code' => 'nullable|regex:/^[A-Za-z]{4}[a-zA-Z0-9]{7}$/',
        'bank_name' => 'nullable|string|max:255',
        'account_no' => 'nullable|digits_between:9,18|unique:franchises,account_no',
        'street' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'district' => 'nullable|string|max:255',
        'pincode' => 'nullable|digits:6',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'doc' => 'nullable|date',
        'status' => 'required|in:active,inactive,pending',
    ];

    protected $messages = [
        'contact_no.digits' => 'Contact number must be 10 digits',
        'aadhar_no.digits' => 'Aadhar number must be 12 digits',
        'pan_no.regex' => 'Invalid PAN number format',
        'ifsc_code.regex' => 'Invalid IFSC code format',
        'pincode.digits' => 'Pincode must be 6 digits',
    ];

    public function fetchAddressFromPincode()
    {
        if (strlen($this->pincode) === 6) {
            try {
                $response = Http::get("https://api.postalpincode.in/pincode/{$this->pincode}");

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data[0]['Status']) && $data[0]['Status'] === 'Success') {
                        if (isset($data[0]['PostOffice']) && count($data[0]['PostOffice']) > 0) {
                            $postOffice = $data[0]['PostOffice'][0];
                            $this->city = $postOffice['District'] ?? '';
                            $this->district = $postOffice['District'] ?? '';
                            $this->state = $postOffice['State'] ?? '';
                            $this->country = $postOffice['Country'] ?? 'India';
                            return;
                        }
                    }
                }

                $this->dispatch('pincode-error', message: 'Could not fetch address details for this pincode');
            } catch (\Exception $e) {
                Log::error("Pincode API error: " . $e->getMessage());
                $this->dispatch('pincode-error', message: 'Error fetching address details. Please enter manually.');
            }
        }
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            Franchise::create([
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

            DB::commit();

            session()->flash('success', 'Franchise created successfully.');
            return redirect()->route('admin.manage-franchises');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Franchise creation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to create franchise. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admin.add-franchises');
    }
}
