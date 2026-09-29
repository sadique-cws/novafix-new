<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class AddFranchises extends Component
{
    public $franchiseId = null;
    public $isEditing = false;

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
    public $city;
    public $district;
    public $pincode;
    public $state;
    public $street;
    public $country = 'India';
    public $doc;
    public $status = 'active';

    public function mount($id = null)
    {
        if ($id) {
            $this->isEditing = true;
            $this->franchiseId = $id;
            $franchise = Franchise::findOrFail($id);

            $this->franchise_name = $franchise->franchise_name;
            $this->contact_no = $franchise->contact_no;
            $this->email = $franchise->email;
            $this->aadhar_no = $franchise->aadhar_no;
            $this->pan_no = $franchise->pan_no;
            $this->ifsc_code = $franchise->ifsc_code;
            $this->bank_name = $franchise->bank_name;
            $this->account_no = $franchise->account_no;
            $this->city = $franchise->city;
            $this->district = $franchise->district;
            $this->pincode = $franchise->pincode;
            $this->state = $franchise->state;
            $this->street = $franchise->street;
            $this->country = $franchise->country ?? 'India';
            $this->doc = $franchise->doc ? \Carbon\Carbon::parse($franchise->doc)->format('Y-m-d') : null;
            $this->status = $franchise->status ?? 'active';
        }
    }

    protected function rules()
    {
        return [
            'franchise_name' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('franchises', 'franchise_name')->ignore($this->franchiseId),
            ],
            'contact_no' => [
                'required', 'digits:10', 'regex:/^[6-9][0-9]{9}$/',
                Rule::unique('franchises', 'contact_no')->ignore($this->franchiseId),
            ],
            'email' => [
                'required', 'email:rfc,dns',
                Rule::unique('franchises', 'email')->ignore($this->franchiseId),
            ],
            'password' => $this->isEditing
                ? 'nullable|string|min:6'
                : 'required|string|min:6',
            'password_confirmation' => $this->isEditing
                ? 'nullable|string|min:6|same:password'
                : 'required|string|min:6|same:password',
            'aadhar_no' => [
                'nullable', 'digits:12', 'regex:/^[2-9]{1}[0-9]{11}$/',
                Rule::unique('franchises', 'aadhar_no')->ignore($this->franchiseId),
            ],
            'pan_no' => [
                'nullable', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                Rule::unique('franchises', 'pan_no')->ignore($this->franchiseId),
            ],
            'ifsc_code' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'account_no' => [
                'nullable', 'digits_between:9,18',
                Rule::unique('franchises', 'account_no')->ignore($this->franchiseId),
            ],
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'pincode' => 'required|digits:6|regex:/^[1-9][0-9]{5}$/',
            'state' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'doc' => 'nullable|date',
            'status' => 'required|in:active,inactive,pending',
        ];
    }

    protected $messages = [
        'contact_no.digits' => 'Contact number must be exactly 10 digits.',
        'contact_no.regex' => 'Contact number must start with 6, 7, 8, or 9.',
        'aadhar_no.digits' => 'Aadhar number must be 12 digits.',
        'aadhar_no.regex' => 'Aadhar number must not start with 0 or 1.',
        'pan_no.regex' => 'PAN must be in format: ABCDE1234F.',
        'pincode.digits' => 'Pincode must be exactly 6 digits.',
        'pincode.regex' => 'Pincode cannot start with 0.',
        'password_confirmation.same' => 'Passwords do not match.',
        'password.min' => 'Password must be at least 6 characters long.',
        'street.required' => 'Street address is required.',
        'street.max' => 'Street address must not exceed 255 characters.',
    ];

    public function submit()
    {
        $this->validate();

        if (!empty($this->password) && $this->password !== $this->password_confirmation) {
            $this->addError('password_confirmation', 'Passwords do not match.');
            return;
        }

        DB::beginTransaction();

        try {
            $data = [
                'franchise_name' => $this->franchise_name,
                'contact_no' => $this->contact_no,
                'email' => $this->email,
                'aadhar_no' => $this->aadhar_no,
                'pan_no' => $this->pan_no,
                'ifsc_code' => $this->ifsc_code,
                'bank_name' => $this->bank_name,
                'account_no' => $this->account_no,
                'city' => $this->city,
                'district' => $this->district,
                'pincode' => $this->pincode,
                'state' => $this->state,
                'street' => $this->street,
                'country' => $this->country,
                'doc' => $this->doc,
                'status' => $this->status,
            ];

            if (!empty($this->password)) {
                $data['password'] = Hash::make($this->password);
            }

            if ($this->isEditing) {
                $franchise = Franchise::findOrFail($this->franchiseId);
                $franchise->update($data);
                DB::commit();
                session()->flash('success', 'Franchise updated successfully ✅');
            } else {
                Franchise::create($data);
                DB::commit();
                session()->flash('success', 'Franchise created successfully ✅');
            }

            return redirect()->route('admin.manage-franchises');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Franchise save failed: ' . $e->getMessage());
            session()->flash('error', '❌ Failed to save franchise. Please try again.');
        }
    }

    /**
     * Live IFSC lookup — relaxed format
     */
    public function updatedIfscCode($value)
    {
        $value = strtoupper(trim($value ?? ''));
        $this->ifsc_code = $value;

        if (!$value) {
            return;
        }

        try {
            $res = Http::timeout(5)->get("https://ifsc.razorpay.com/{$value}");
            if ($res->ok()) {
                $data = $res->json();
                $this->bank_name = $data['BANK'] ?? ($data['bank'] ?? null);
                $this->clearValidation('ifsc_code');
            } else {
                Log::warning('IFSC lookup failed', ['ifsc' => $value, 'status' => $res->status()]);
                $this->bank_name = null;
                $this->addError('ifsc_code', 'IFSC not found in our database.');
            }
        } catch (\Exception $e) {
            Log::error('IFSC lookup error: ' . $e->getMessage());
            $this->bank_name = null;
            $this->addError('ifsc_code', 'Error fetching bank details. Please try again.');
        }
    }

    /**
     * Live Pincode lookup
     */
    public function updatedPincode($value)
    {
        $value = trim($value ?? '');
        $this->pincode = $value;

        if (!$value) {
            return;
        }

        if (!preg_match('/^[1-9][0-9]{5}$/', $value)) {
            return;
        }

        try {
            $res = Http::timeout(5)->get("https://www.api.postalpincode.in/pincode/{$value}");
            if ($res->ok()) {
                $arr = $res->json();
                if (is_array($arr) && isset($arr[0]['Status']) && $arr[0]['Status'] === 'Success' && !empty($arr[0]['PostOffice'])) {
                    $po = $arr[0]['PostOffice'][0];
                    $this->city = $po['Region'] ?? $po['Block'] ?? $po['Division'] ?? $this->city;
                    $this->district = $po['District'] ?? $this->district;
                    $this->state = $po['State'] ?? $this->state;
                } else {
                    $this->dispatch('notify', type: 'error', message: 'Pincode not found.');
                }
            } else {
                Log::warning('Pincode API returned non-200', ['pincode' => $value, 'status' => $res->status()]);
                $this->dispatch('notify', type: 'error', message: 'Error fetching address details.');
            }
        } catch (\Exception $e) {
            Log::error("Pincode API error: " . $e->getMessage());
            $this->dispatch('notify', type: 'error', message: 'Error fetching address details. Please enter manually.');
        }
    }

    public function render()
    {
        return view('livewire.admin.add-franchises')
            ->title($this->isEditing ? 'Edit Franchise' : 'Add Franchise');
    }
}
