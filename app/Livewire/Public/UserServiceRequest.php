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

    protected function generateServiceCode()
    {
        do {
            $randomLetters = strtoupper(Str::random(6));

            $newCode = $randomLetters;

            $exists = ServiceRequest::where('service_code', $newCode)->exists();

        } while ($exists); // Repeat until we get a unique one

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
                session()->flash('error', 'failed to upload image, please try again');
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
