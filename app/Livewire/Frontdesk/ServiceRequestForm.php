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
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.frontdesk-layout')]

class ServiceRequestForm extends Component
{
    use WithFileUploads;

    // Form fields - updated to match database
    public $receptioners_id;
    public $technician_id;
    public $service_categories_id;
    public $service_code;
    public $owner_name;
    public $product_name;
    public $email;
    public $contact;
    public $brand;
    public $serial_no;
    public $MAC;
    public $color;
    public $service_amount = 0;
    public $problem;
    public $status = 0.00;
    public $last_update;
    public $delivered_by;
    public $delivery_status = false;
    public $estimate_delivery;
    public $date_of_delivery;
    public $image;
    public $capturedImage;
    public $cameraError;

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
            'estimate_delivery' => 'required|date',
            'date_of_delivery' => 'nullable|date|after_or_equal:estimate_delivery',
            'image' => 'nullable|image',
        ];
    }

    public function mount()
    {
        $this->receptioners_id = Auth::guard('frontdesk')->user()->id;
        $this->last_update = now();
        $this->estimate_delivery = Carbon::now()->addDays(3);
        $this->generateServiceCode();
        $this->generateSerialNumber();
    }
    public function updatedImage()
    {
        $this->validate([
            'image' => 'image', // 1MB Max
        ]);
    }
    public function setCapturedImage($imageData)
    {
        $this->capturedImage = $imageData;
        $this->image = null; // Clear file upload if exists
    }

    protected function generateServiceCode()
    {
        $datePart = now()->format('Ymd');
        $randomPart = Str::upper(Str::random(4));
        $this->service_code = "SR-{$datePart}-{$randomPart}";
    }
    public function removeImage()
    {
        $this->reset('image', 'capturedImage');
    }

    protected function generateSerialNumber()
    {
        $lastRequest = ServiceRequest::orderBy('id', 'desc')->first();
        $lastSerial = $lastRequest ? intval(preg_replace('/[^0-9]/', '', $lastRequest->serial_no)) : 0;
        $this->estimate_delivery = Carbon::now()->addDays(3)->format('Y-m-d\TH:i');
        $this->serial_no = 'SN-' . str_pad($lastSerial + 1, 6, '0', STR_PAD_LEFT);
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $imagePath = null;
            if ($this->capturedImage) {
                $imagePath = $this->storeCapturedImage();
            } elseif ($this->image) {
                $imagePath = $this->image->store('service-requests', 'public');
            }

            $serviceRequest = ServiceRequest::create([
                'receptioners_id' => $this->receptioners_id,
                'technician_id' => $this->technician_id,
                'service_categories_id' => $this->service_categories_id,
                'service_code' => $this->service_code,
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
                'last_update' => $this->last_update,
                'delivered_by' => $this->delivered_by,
                'delivery_status' => $this->delivery_status,
                'estimate_delivery' => $this->estimate_delivery,
                'date_of_delivery' => $this->date_of_delivery,
                'image' => $imagePath
            ]);

            DB::commit();

            session()->flash('success', 'Service request created successfully!');
            return redirect()->route('frontdesk.servicerequest.manage');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            session()->flash('error', 'Failed to create service request: ' . $e->getMessage());
            logger()->error('Service Request Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }


    protected function storeCapturedImage()
    {
        try {
            if (!Str::startsWith($this->capturedImage, 'data:image/jpeg;base64,')) {
                throw new \Exception('Invalid image format');
            }

            $imageData = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $this->capturedImage));

            if (!$imageData) {
                throw new \Exception('Failed to decode image');
            }

            $fileName = 'captured_' . time() . '.jpg';
            $path = 'service-requests/' . $fileName;

            if (!Storage::disk('public')->put($path, $imageData)) {
                throw new \Exception('Failed to store image');
            }

            return $path;
        } catch (\Exception $e) {
            $this->cameraError = $e->getMessage();
            throw $e;
        }
    }

    public function clearImage()
    {
        $this->reset('image', 'capturedImage', 'cameraError');
    }

    public function resetForm()
    {
        $this->resetExcept(['technicians', 'categories']);
        $this->estimate_delivery = Carbon::now()->addDays(3)->format('Y-m-d\TH:i');
        $this->generateServiceCode();
        $this->generateSerialNumber();
    }

    public function render()
    {
        return view('livewire.frontdesk.service-request-form', [
            'technicians' => Staff::all(),
            'categories' => ServiceCategory::all(),
        ]);
    }
}