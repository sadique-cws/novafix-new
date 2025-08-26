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
    public $imagekit_url;
    public $uploadProgress = 0;
    public $submitted = false;
    public $serviceCode = '';


    public $serviceCategories = [];
    public $franchises = [];
    public $service_code;

    protected $rules = [
        'franchise_id'          => 'required|exists:franchises,id',
        'service_categories_id' => 'required|exists:service_categories,id',
        'owner_name'            => 'required|string|max:255',
        'product_name'          => 'required|string|max:255',
        'email'                 => 'nullable|email',
        'contact' => [
            'required',
            'regex:/^[6-9][0-9]{9}$/', 
            'unique:service_requests,contact',
        ],

        'brand'                 => 'required|string|max:255',
        'color'                 => 'required|string|max:100',
        'problem'               => 'required|string|max:500',
        'image'                 => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        // load categories & franchises
        $this->serviceCategories = ServiceCategory::all();
        $this->franchises = Franchise::all();
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048',
        ]);

        $this->imagekit_url = null;
        $this->uploadProgress = 10;
    }
    protected function generateServiceCode()
    {
        $prefix = "NFSR-";
        $lastRequest = ServiceRequest::orderBy('id', 'desc')->first();

        if ($lastRequest && !empty($lastRequest->service_code)) {
            // Check if the existing code has our prefix
            if (str_starts_with($lastRequest->service_code, $prefix)) {
                // Extract the numeric part from the existing code
                $numericPart = substr($lastRequest->service_code, strlen($prefix));
                $lastNumber = (int) $numericPart;
                $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            } else {
                // If the code doesn't have our prefix, start from 1
                $newNumber = '00001';
            }
        } else {
            // No existing records or empty service_code
            $newNumber = '00001';
        }

        return $prefix . $newNumber;
    }


    protected function uploadToImageKit()
    {
        try {
            $this->uploadProgress = 30;
            $result = ImageKitHelper::uploadImage($this->image, 'public-service-requests');
            $this->uploadProgress = 100;
            return $result;
        } catch (\Exception $e) {
            $this->uploadProgress = 0;
            throw new \Exception('Failed to upload image: ' . $e->getMessage());
        }
    }

    public function removeImage()
    {
        $this->reset('image', 'imagekit_url', 'uploadProgress');
    }

    public function save()
    {
        $this->validate();

        $serviceCode = $this->generateServiceCode();

        $imagePath = null;
        if ($this->image) {
            $imagekitData = $this->uploadToImageKit();

            if ($imagekitData && isset($imagekitData['url'])) {
                $imagePath = $imagekitData['url'];
                $this->imagekit_url = $imagePath;
            } else {
                session()->flash('error', 'Failed to upload image. Please try again.');
                return;
            }
        }

        ServiceRequest::create([
            'franchise_id'          => $this->franchise_id,
            'service_categories_id' => $this->service_categories_id,
            'service_code'          => $serviceCode,
            'owner_name'            => $this->owner_name,
            'product_name'          => $this->product_name,
            'email'                 => $this->email,
            'contact'               => $this->contact,
            'brand'                 => $this->brand,
            'color'                 => $this->color,
            'problem'               => $this->problem,
            'image'                 => $imagePath,
        ]);

        $this->serviceCode = $serviceCode;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public.user-service-request', [
            'serviceCategories' => $this->serviceCategories,
            'franchises'        => $this->franchises,
        ]);
    }
}
