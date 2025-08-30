<?php


namespace App\Livewire\Admin;

use App\Models\Franchise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;

#[Title('Add Franchise')]
#[Layout('components.layouts.admin-layout')]

class AddFranchises extends Component
{
        #[Rule('required|string|min:3|unique:franchises,franchise_name|max:255')]
    public $franchise_name;

    #[Rule('required|digits:10|regex:/^[6-9][0-9]{9}$/|unique:franchises,contact_no')]
    public $contact_no;

    #[Rule('required|email:rfc,dns|unique:franchises,email')]
    public $email;
    
    #[Rule('required|string|min:8')]
    public $password;
    
    #[Rule('required|string|min:8|same:password')]
    public $password_confirmation;

    #[Rule('nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/|unique:franchises,aadhar_no')]
    public $aadhar_no;

    #[Rule('nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/|unique:franchises,pan_no')]
    public $pan_no;

    #[Rule('nullable|regex:/^[A-Z]{4}0[0-9]{6}$/')]
    public $ifsc_code;

    #[Rule('nullable|string|max:255')]
    public $bank_name;

    #[Rule('nullable|digits_between:9,18|unique:franchises,account_no')]
    public $account_no;

    #[Rule('nullable|string|max:255')]
    public $street;

    #[Rule('nullable|string|max:255')]
    public $city;

    #[Rule('nullable|string|max:255')]
    public $district;

    #[Rule('required|digits:6|regex:/^[1-9][0-9]{5}$/')]
    public $pincode;

    #[Rule('required|string|max:255')]
    public $state;

    #[Rule('required|string|max:255')]
    public $country = 'India';

    #[Rule('nullable|date')]
    public $doc;

    public $status = 'active';

    protected $messages = [
        'contact_no.digits' => 'Contact number must be exactly 10 digits.',
        'contact_no.regex' => 'Contact number must start with 6, 7, 8, or 9.',
        'aadhar_no.digits' => 'Aadhar number must be 12 digits.',
        'aadhar_no.regex' => 'Aadhar number must not start with 0 or 1.',
        'pan_no.regex' => 'PAN must be in format: ABCDE1234F.',
        'ifsc_code.regex' => 'IFSC must follow RBI format (e.g., HDFC0001234).',
        'pincode.digits' => 'Pincode must be exactly 6 digits.',
        'pincode.regex' => 'Pincode cannot start with 0.',
        'password_confirmation.same' => 'Passwords do not match.',
        'password.min' => 'Password must be at least 8 characters long.',
    ];

    public function submit()
    {
        $this->validate();
        
        // Check if password confirmation matches
        if ($this->password !== $this->password_confirmation) {
            $this->addError('password_confirmation', 'Passwords do not match.');
            return;
        }

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

            session()->flash('success', 'Franchise created successfully ✅');
            return redirect()->route('admin.manage-franchises');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Franchise creation failed: ' . $e->getMessage());
            session()->flash('error', '❌ Failed to create franchise. Please try again.');
        }
    }


    /**
     * Live IFSC lookup — when IFSC changes this will be invoked.
     */
    public function updatedIfscCode($value)
    {
        $value = strtoupper(trim($value ?? ''));
        $this->ifsc_code = $value;

        if (!$value) {
            return;
        }

        // quick client-side pattern check to avoid unnecessary requests
        if (!preg_match('/^[A-Z]{4}0[0-9]{6}$/', $value)) {
            // invalid IFSC format — clear bank name and exit
            $this->bank_name = null;
            return;
        }

        try {
            $res = Http::timeout(5)->get("https://ifsc.razorpay.com/{$value}");
            if ($res->ok()) {
                $data = $res->json();
                // Razorpay IFSC API returns keys like BANK, BRANCH
                $this->bank_name = $data['BANK'] ?? ($data['bank'] ?? null);
            } else {
                Log::warning('IFSC lookup failed', ['ifsc' => $value, 'status' => $res->status()]);
                $this->bank_name = null;
                $this->dispatch('notify', type: 'error', message: 'IFSC not found');
            }
        } catch (\Exception $e) {
            Log::error('IFSC lookup error: ' . $e->getMessage());
            $this->bank_name = null;
            $this->dispatch('notify', type: 'error', message: 'Error fetching bank details.');
        }
    }

    /**
     * Live Pincode lookup — when pincode changes this will be invoked.
     */
    public function updatedPincode($value)
    {
        $value = trim($value ?? '');
        $this->pincode = $value;

        if (!$value) {
            return;
        }

        // Validate Indian pincode
        if (!preg_match('/^[1-9][0-9]{5}$/', $value)) {
            return;
        }

        try {
            $res = Http::timeout(5)->get("https://www.api.postalpincode.in/pincode/{$value}");
            if ($res->ok()) {
                $arr = $res->json();
                if (is_array($arr) && isset($arr[0]['Status']) && $arr[0]['Status'] === 'Success' && !empty($arr[0]['PostOffice'])) {
                    $po = $arr[0]['PostOffice'][0];
                    // set sensible fallbacks from response
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
        return view('livewire.admin.add-franchises');
    }
}