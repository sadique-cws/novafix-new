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
            'serial_no' => 'nullable|string|max:255',
            'MAC' => 'nullable|string|max:255',
            'color' => 'required|string|max:100',
            'service_amount' => 'nullable|numeric|min:0',
            'problem' => 'required|string',
            'status' => 'required|numeric',
            'estimate_delivery' => 'required|date',
            'date_of_delivery' => 'nullable|date|after_or_equal:estimate_delivery',
            'image' => 'nullable|image',
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
        $this->existingImage = $this->serviceRequest->image;
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image', // 1MB Max
        ]);

        // Clear existing and captured images when a new file is selected
        $this->existingImage = null;
        $this->capturedImage = null;
    }

    public function removeImage()
    {
        $this->reset('image', 'capturedImage');
        $this->existingImage = null;
    }

    public function setCapturedImage($imageData)
    {
        $this->capturedImage = $imageData;
        $this->image = null; // Clear file upload if exists
    }

   

    public function update()
    {
        $this->validate();

        try {
            $imagePath = $this->existingImage;

            // Handle new image upload
            if ($this->capturedImage) {
                $imagePath = $this->storeCapturedImage();
                $this->deleteOldImage();
            } elseif ($this->image) {
                $imagePath = $this->image->store('service-requests', 'public');
                $this->deleteOldImage();
            }

            $this->serviceRequest->update([
                'technician_id' => $this->technician_id,
                'service_categories_id' => $this->service_categories_id,
                'owner_name' => $this->owner_name,
                'product_name' => $this->product_name,
                'email' => $this->email,
                'contact' => $this->contact,
                'brand' => $this->brand,
                'serial_no' => $this->serial_no,
                'MAC' => $this->MAC,
                'color' => $this->color,
                'service_amount' => $this->service_amount,
                'problem' => $this->problem,
                'status' => $this->status,
                'estimate_delivery' => $this->estimate_delivery,
                'date_of_delivery' => $this->date_of_delivery,
                'image' => $imagePath,
                'last_update' => now(),
            ]);

            session()->flash('success', 'Service request updated successfully!');
            return redirect()->route('frontdesk.servicerequest.manage');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update service request: ' . $e->getMessage());
            logger()->error('Service Request Update Error: ' . $e->getMessage());
        }
    }

    protected function storeCapturedImage()
    {
        try {
            $imageData = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $this->capturedImage));
            $fileName = 'captured_' . time() . '.jpg';
            $path = 'service-requests/' . $fileName;
            Storage::disk('public')->put($path, $imageData);
            return $path;
        } catch (\Exception $e) {
            $this->cameraError = $e->getMessage();
            throw $e;
        }
    }

    protected function deleteOldImage()
    {
        if ($this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
            Storage::disk('public')->delete($this->existingImage);
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
