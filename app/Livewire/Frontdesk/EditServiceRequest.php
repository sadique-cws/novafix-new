<?php

namespace App\Livewire\Frontdesk;

use Livewire\Component;
use App\Models\Staff;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Helpers\ImageKitHelper;

#[Title('Edit Service Request')]
#[Layout('components.layouts.frontdesk-layout')]

class EditServiceRequest extends Component
{
    use WithFileUploads;

    public $serviceRequest;
    public $technician_id;
    public $service_categories_id;
    public $owner_name;
    public $product_name;
    public $email;
    public $contact;
    public $brand;
    public $serial_no;
    public $MAC;
    public $color;
    public $service_amount;
    public $problem;
    public $status;
    public $estimate_delivery;
    public $date_of_delivery;
    public $image;
    public $capturedImage;
    public $cameraError;
    public $existingImage;
    public $imagekit_url;
    public $uploadProgress = 0;

    protected function rules()
    {
        return [
            'service_categories_id' => 'required|exists:service_categories,id',
            'technician_id' => 'nullable|exists:staff,id',
            'owner_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact' => 'required|string|max:20',
            'brand' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'service_amount' => 'nullable|numeric|min:0',
            'problem' => 'required|string',
            'status' => 'required|numeric',
            'estimate_delivery' => 'required|date',
            'image' => 'nullable|image|max:5120',
        ];
    }

    public function mount($id)
    {
        $this->serviceRequest = ServiceRequest::findOrFail($id);

        // Populate form fields
        $this->technician_id = $this->serviceRequest->technician_id;
        $this->service_categories_id = $this->serviceRequest->service_categories_id;
        $this->owner_name = $this->serviceRequest->owner_name;
        $this->product_name = $this->serviceRequest->product_name;
        $this->email = $this->serviceRequest->email;
        $this->contact = $this->serviceRequest->contact;
        $this->brand = $this->serviceRequest->brand;
        $this->serial_no = $this->serviceRequest->serial_no;
        $this->MAC = $this->serviceRequest->MAC;
        $this->color = $this->serviceRequest->color;
        $this->service_amount = $this->serviceRequest->service_amount;
        $this->problem = $this->serviceRequest->problem;
        $this->status = $this->serviceRequest->status;
        $this->estimate_delivery = Carbon::parse($this->serviceRequest->estimate_delivery)->format('Y-m-d\TH:i');
        $this->date_of_delivery = $this->serviceRequest->date_of_delivery
            ? Carbon::parse($this->serviceRequest->date_of_delivery)->format('Y-m-d\TH:i')
            : null;
        $this->existingImage = $this->serviceRequest->image_url; // Changed from image to image_url
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:5120',
        ]);

        // Clear existing and captured images when a new file is selected
        $this->existingImage = null;
        $this->capturedImage = null;
        $this->imagekit_url = null;
    }

    public function removeImage()
    {
        $this->reset('image', 'capturedImage', 'imagekit_url', 'uploadProgress');
        $this->existingImage = null;
    }

    public function setCapturedImage($imageData)
    {
        $this->capturedImage = $imageData;
        $this->image = null; // Clear file upload if exists
        $this->imagekit_url = null;
    }

    public function update()
    {
        $this->validate();

        try {
            $imagePath = $this->existingImage;
            $imageFileId = $this->serviceRequest->image_file_id;

            // Handle new image upload
            if ($this->capturedImage || $this->image) {
                $this->uploadProgress = 10;
                $imagekitData = $this->uploadToImageKit();
                $this->uploadProgress = 100;

                if ($imagekitData && isset($imagekitData['url'])) {
                    $imagePath = $imagekitData['url'];
                    $imageFileId = $imagekitData['fileId'];
                    
                    // Delete old image from ImageKit if exists
                    if ($this->serviceRequest->image_file_id) {
                        ImageKitHelper::deleteImage($this->serviceRequest->image_file_id);
                    }
                } else {
                    throw new \Exception('Failed to upload image to ImageKit');
                }
            }

            // Only update columns that actually exist on the service_requests table
            $this->serviceRequest->update([
                'technician_id' => $this->technician_id,
                'service_categories_id' => $this->service_categories_id,
                'owner_name' => $this->owner_name,
                'product_name' => $this->product_name,
                'email' => $this->email,
                'contact' => $this->contact,
                'brand' => $this->brand,
                'color' => $this->color,
                'service_amount' => $this->service_amount,
                'problem' => $this->problem,
                'status' => $this->status,
                'estimate_delivery' => $this->estimate_delivery,
                'image_url' => $imagePath, // Changed from 'image' to 'image_url'
                'image_file_id' => $imageFileId, // Update file ID if new image uploaded
                'last_update' => now(),
            ]);

            session()->flash('success', 'Service request updated successfully!');
            return redirect()->route('frontdesk.servicerequest.manage');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update service request: ' . $e->getMessage());
            logger()->error('Service Request Update Error: ' . $e->getMessage());
            $this->uploadProgress = 0;
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

    public function render()
    {
        return view('livewire.frontdesk.edit-service-request', [
            'technicians' => Staff::all(),
            'categories' => ServiceCategory::all(),
        ]);
    }
}