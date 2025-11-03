<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServiceRequest;
use App\Models\ServiceCategory;
use App\Models\Franchise;
use Illuminate\Support\Str;
use App\Helpers\ImageKitHelper;

class UserServiceRequest extends Component
{
    use WithFileUploads;

    // Form properties
    public $franchise_id;
    public $service_categories_id;
    public $owner_name;
    public $product_name;
    public $email;
    public $contact;
    public $brand;
    public $color;
    public $problem;
    public $image;
    public $submitted = false;
    public $serviceCode = '';
    public $serviceCategories = [];
    public $franchises = [];
    public $service_code;
    public $isExistingCustomer = false;

    protected $rules = [
        'franchise_id' => 'required|exists:franchises,id',
        'service_categories_id' => 'required|exists:service_categories,id',
        'owner_name' => 'required|string|max:255',
        'product_name' => 'required|string|max:255',
        'email' => 'nullable|email',
        'contact' => [
            'required',
            'regex:/^[6-9][0-9]{9}$/',
        ],
        'brand' => 'required|string|max:255',
        'color' => 'required|string|max:100',
        'problem' => 'required|string|max:500',
        'image' => 'nullable|image',
    ];

    public function mount()
    {
        // load categories & franchises
        $this->serviceCategories = ServiceCategory::all();
        $this->franchises = Franchise::where('status', 'active')->get();
    }

    // This will be called automatically when contact property changes
    public function updatedContact($value)
    {
        // Remove any non-numeric characters
        $cleanContact = preg_replace('/[^0-9]/', '', $value);
        
        // Check if we have exactly 10 digits
        if (strlen($cleanContact) === 10) {
            $this->checkExistingCustomer($cleanContact);
        } else {
            $this->isExistingCustomer = false;
            $this->clearAutoFilledFields();
        }
    }

    protected function checkExistingCustomer($contact)
    {
        // Find the latest service request for this contact number
        $existingRequest = ServiceRequest::where('contact', $contact)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($existingRequest) {
            $this->isExistingCustomer = true;
            
            // Auto-fill the form with existing customer data
            $this->owner_name = $existingRequest->owner_name;
            $this->email = $existingRequest->email;
            $this->brand = $existingRequest->brand;
            $this->color = $existingRequest->color;
            
            // Show success message
            session()->flash('info', 'Welcome back! We found your previous details and auto-filled the form.');
        } else {
            $this->isExistingCustomer = false;
            $this->clearAutoFilledFields();
        }
    }

    protected function clearAutoFilledFields()
    {
        // Only clear auto-filled fields if they match the pattern of being auto-filled
        // This prevents clearing user input
        if ($this->isExistingCustomer) {
            $this->owner_name = '';
            $this->email = '';
            $this->brand = '';
            $this->color = '';
        }
    }

    protected function generateServiceCode()
    {
        do {
            $randomLetters = strtoupper(Str::random(6));
            $newCode = $randomLetters;
            $exists = ServiceRequest::where('service_code', $newCode)->exists();
        } while ($exists);

        return $newCode;
    }

    public function save()
    {
        $this->validate();
        $serviceCode = $this->generateServiceCode();

        $data = [
            'franchise_id' => $this->franchise_id,
            'service_categories_id' => $this->service_categories_id,
            'service_code' => $serviceCode,
            'owner_name' => $this->owner_name,
            'product_name' => $this->product_name,
            'email' => $this->email,
            'contact' => $this->contact,
            'brand' => $this->brand,
            'color' => $this->color,
            'problem' => $this->problem,
        ];

        if ($this->image) {
            $imageData = ImageKitHelper::uploadImage($this->image, '/Novafix/service-requests');

            if ($imageData) {
                $data['image_url'] = $imageData['url'];
                $data['image_file_id'] = $imageData['fileId'];
            } else {
                session()->flash('error', 'Failed to upload image, please try again');
                return;
            }
        }

        ServiceRequest::create($data);
        $this->serviceCode = $serviceCode;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public.user-service-request', [
            'serviceCategories' => $this->serviceCategories,
            'franchises' => $this->franchises,
        ]);
    }
}