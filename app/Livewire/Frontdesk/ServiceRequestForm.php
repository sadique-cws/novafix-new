<?php

namespace App\Livewire\Frontdesk;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Staff;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Helpers\ImageKitHelper;

#[Title('Service Request Form')]
#[Layout('components.layouts.frontdesk-layout')]
class ServiceRequestForm extends Component
{
    use WithFileUploads;

    // Form fields
    public $receptioners_id;
    public $technician_id;
    public $franchise_id;
    public $service_categories_id;
    public $service_code;
    public $owner_name;
    public $product_name;
    public $email;
    public $contact;
    public $brand;
    public $color;
    public $service_amount;
    public $problem;
    public $status = 0.00;
    public $last_update;
    public $delivered_by;
    public $delivery_status = false;
    public $estimate_delivery;
    public $image;
    public $capturedImage;
    public $cameraError;
    public $technician;
    public $imagekit_url;
    public $uploadProgress = 0;
    public $serial_no;

    protected function rules()
    {
        return [
            'service_categories_id' => 'required|exists:service_categories,id',
            'technician_id' => 'nullable|exists:staff,id',
            'franchise_id' => 'nullable|exists:franchises,id',
            'serial_no' =>'required',
            'owner_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact' => 'required|regex:/^[6-9]\d{9}$/',
            'brand' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'service_amount' => 'nullable|numeric|min:0',
            'problem' => 'required|string',
            'estimate_delivery' => 'date',
            'image' => 'nullable|image|max:5120',
        ];
    }

    public function mount()
    {
        // Safely set receptioners_id only if frontdesk guard is authenticated
        if (Auth::guard('frontdesk')->check()) {
            $this->receptioners_id = Auth::guard('frontdesk')->user()->id;
        }
        $this->last_update = now();
        $this->estimate_delivery = Carbon::now()->addDays(3)->format('Y-m-d');
        $this->generateServiceCode();
        $this->franchise_id = Auth::guard('frontdesk')->user()->franchise_id ?? null;
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:5120',
        ]);

        $this->capturedImage = null;
        $this->imagekit_url = null;
    }

    public function setCapturedImage($imageData)
    {
        $this->capturedImage = $imageData;
        $this->image = null;
        $this->imagekit_url = null;
    }

    protected function generateServiceCode()
    {
        do {
            $newCode = '';
            for ($i = 0; $i < 6; $i++) {
                $newCode .= chr(rand(65, 90)); // 65–90 = A–Z
            }

            // Check uniqueness in DB
            $exists = ServiceRequest::where('service_code', $newCode)->exists();
        } while ($exists);

        $this->service_code = $newCode;
        $this->estimate_delivery = now()->addDays(3)->format('Y-m-d');
    }
    


    public function removeImage()
    {
        $this->reset('image', 'capturedImage', 'imagekit_url', 'uploadProgress');
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $imagePath = null;

            // Upload to ImageKit if image exists
            if ($this->capturedImage || $this->image) {
                $this->uploadProgress = 10;
                $imagekitData = $this->uploadToImageKit();
                $this->uploadProgress = 100;

                if ($imagekitData && isset($imagekitData['url'])) {
                    $imagePath = $imagekitData['url'];
                    $imageFIleId = $imagekitData['fileId'];
                } else {
                    throw new \Exception('Failed to upload image to ImageKit');
                }
            }

            $serviceRequest = ServiceRequest::create([
                'receptioners_id' => $this->receptioners_id,
                'serial_no' => $this->serial_no,
                'technician_id' => $this->technician_id,
                'service_categories_id' => $this->service_categories_id,
                'franchise_id' => $this->franchise_id,
                'service_code' => $this->service_code,
                'owner_name' => $this->owner_name,
                'product_name' => $this->product_name,
                'email' => $this->email,
                'contact' => $this->contact,
                'brand' => $this->brand,
                'color' => $this->color,
                'service_amount' => $this->service_amount,
                'problem' => $this->problem,
                'status' => $this->status,
                'last_update' => $this->last_update,
                'delivered_by' => $this->delivered_by,
                'delivery_status' => $this->delivery_status,
                'estimate_delivery' => $this->estimate_delivery,
                'image_url' => $imagePath,
                'image_file_id' => $imageFIleId,
                'status_request' => 1,
                // Removed the imagekit_data field as it doesn't exist in the database
            ]);

            DB::commit();

            session()->flash('success', 'Service request created successfully!');
            return redirect()->route('reviewServiceRequest', $serviceRequest->id);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->uploadProgress = 0;
            session()->flash('error', 'Failed to create service request: ' . $e->getMessage());
            logger()->error('Service Request Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    protected function uploadToImageKit()
    {
        try {
            // Handle captured image (from webcam)
            if ($this->capturedImage) {
                $this->uploadProgress = 30;

                // Convert base64 image to a temporary file
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->capturedImage));
                $tempFilePath = tempnam(sys_get_temp_dir(), 'img');
                file_put_contents($tempFilePath, $imageData);

                // Create UploadedFile instance
                $uploadedFile = new \Illuminate\Http\UploadedFile(
                    $tempFilePath,
                    'webcam_capture.jpg',
                    'image/jpeg',
                    null,
                    true
                );

                // Upload using ImageKitHelper
                $result = ImageKitHelper::uploadImage($uploadedFile, '/Novafix/service-requests');

                // Clean up temporary file
                unlink($tempFilePath);

                return $result;
            }
            // Handle file upload
            elseif ($this->image) {
                $this->uploadProgress = 30;
                return ImageKitHelper::uploadImage($this->image, 'service-requests');
            }

            return null;
        } catch (\Exception $e) {
            $this->cameraError = $e->getMessage();
            $this->uploadProgress = 0;
            throw $e;
        }
    }

    public function clearImage()
    {
        $this->reset('image', 'capturedImage', 'cameraError', 'imagekit_url', 'uploadProgress');
    }

    public function resetForm()
    {
        $this->resetExcept(['technicians', 'categories']);
        $this->estimate_delivery = Carbon::now()->addDays(3)->format('Y-m-d');
        $this->generateServiceCode();
    }

    public function render()
    {
        // Determine franchise id from the authenticated frontdesk (receptioner) user first.
        $franchiseId = null;

        // If frontdesk (receptioner) is logged in, prefer their franchise_id
        if (Auth::guard('frontdesk')->check()) {
            $frontdeskUser = Auth::guard('frontdesk')->user();
            // try explicit franchise_id, else try relation
            $franchiseId = $frontdeskUser->franchise_id ?? optional($frontdeskUser->franchise)->id;
        }

        // If franchise guard is logged in use that id
        if (!$franchiseId && auth('franchise')->check()) {
            $franchiseId = auth('franchise')->id();
        }

        // If we have a franchise id, filter technicians by franchise, otherwise show all technicians
        $technicians = $franchiseId ? Staff::where('franchise_id', $franchiseId)->get() : Staff::all();
        return view('livewire.frontdesk.service-request-form', [
            'technicians' => $technicians,
            'categories' => ServiceCategory::all(),
            'brands' => Brand::select('name')->get(),
        ]);
    }
}
