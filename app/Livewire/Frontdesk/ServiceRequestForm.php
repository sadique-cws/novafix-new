<?php

namespace App\Livewire\Frontdesk;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Staff;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use App\Models\Customer;
use App\Models\Shop;
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
    public $amount_paid = 0;
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
    public $request_type = 'customer';
    public $shop_id;
    public $new_shop_name;
    public $new_owner_name;
    public $new_contact;
    public $new_email;
    public $new_address;
    public $new_gst_number;

    protected function rules()
    {
        $rules = [
            'service_categories_id' => 'required|exists:service_categories,id',
            'technician_id' => 'nullable|exists:staff,id',
            'franchise_id' => 'nullable|exists:franchises,id',
            'serial_no' => 'required',
            'product_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'service_amount' => 'nullable|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'problem' => 'required|string',
            'estimate_delivery' => 'date',
            'image' => 'nullable|image|max:5120',
        ];

        if ($this->request_type === 'customer') {
            $rules['owner_name'] = 'required|string|max:255';
            $rules['contact'] = 'required|regex:/^[6-9]\d{9}$/';
            $rules['email'] = 'nullable|email|max:255';
        } else {
            $rules['shop_id'] = 'required';
            if ($this->shop_id === 'new') {
                $rules['new_shop_name'] = 'required|string|max:255';
                $rules['new_owner_name'] = 'required|string|max:255';
                $rules['new_contact'] = 'required|regex:/^[6-9]\d{9}$/';
                $rules['new_email'] = 'nullable|email|max:255';
            }
        }

        return $rules;
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


    public function updatedShopId($value)
    {
        if ($value) {
            $shop = Shop::find($value);
            if ($shop) {
                $this->owner_name = $shop->owner_name ?? $shop->shop_name;
                $this->contact = $shop->contact;
                $this->email = $shop->email;
            }
        }
    }

    public function updatedContact($value)
    {
        if (strlen($value) == 10) {
            $customer = Customer::where('contact', $value);
            if ($this->franchise_id) {
                $customer->where('franchise_id', $this->franchise_id);
            }
            $customer = $customer->first();

            if ($customer) {
                $this->owner_name = $customer->name;
                $this->email = $customer->email;
            }
        }
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
            if ($this->request_type === 'shop') {
                if ($this->shop_id === 'new') {
                    $shop = Shop::create([
                        'franchise_id' => $this->franchise_id,
                        'shop_name' => $this->new_shop_name,
                        'owner_name' => $this->new_owner_name,
                        'contact' => $this->new_contact,
                        'email' => $this->new_email,
                        'address' => $this->new_address,
                        'gst_number' => $this->new_gst_number,
                    ]);
                    $this->shop_id = $shop->id;
                    $this->owner_name = $shop->owner_name ?? $shop->shop_name;
                    $this->contact = $shop->contact;
                    $this->email = $shop->email;
                } else {
                    $shop = Shop::find($this->shop_id);
                    if ($shop) {
                        $this->owner_name = $shop->owner_name ?? $shop->shop_name;
                        $this->contact = $shop->contact;
                        $this->email = $shop->email;
                    }
                }
            }

            $imagePath = null;
            // ensure file id variable exists even when no image is uploaded
            $imageFIleId = null;

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
                'is_shop' => $this->request_type === 'shop',
                'shop_id' => $this->request_type === 'shop' ? $this->shop_id : null,
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
                'problem' => $this->problem,
                'status' => $this->status,
                'last_update' => $this->last_update,
                'delivered_by' => $this->delivered_by,
                'delivery_status' => $this->delivery_status,
                'estimate_delivery' => $this->estimate_delivery,
                'image_url' => $imagePath,
                'image_file_id' => $imageFIleId,
                'status_request' => 1,
            ]);

            // Calculate payment status
            $total = (float)($this->service_amount ?? 0);
            $paid = (float)($this->amount_paid ?? 0);
            $due = max($total - $paid, 0);

            $paymentStatus = 'pending';
            if ($paid > 0 && $due > 0) {
                $paymentStatus = 'partial';
            } elseif ($paid >= $total && $total > 0) {
                $paymentStatus = 'completed';
            }

            // Create master payment record
            $payment = \App\Models\Payment::create([
                'service_request_id' => $serviceRequest->id,
                'amount' => $total,
                'total_amount' => $total,
                'paid_amount' => $paid,
                'due_amount' => $due,
                'status' => $paymentStatus,
                'received_by' => $this->receptioners_id,
            ]);

            // Create initial transaction if anything is paid
            if ($paid > 0) {
                \App\Models\PaymentTransaction::create([
                    'payment_id' => $payment->id,
                    'service_request_id' => $serviceRequest->id,
                    'amount_paid' => $paid,
                    'payment_method' => 'cash',
                    'received_by' => $this->receptioners_id,
                    'notes' => 'Advance Payment',
                ]);
            }

            // Save or Update Customer if direct customer
            if ($this->request_type === 'customer' && $this->contact) {
                Customer::updateOrCreate(
                    [
                        'contact' => $this->contact,
                        'franchise_id' => $this->franchise_id
                    ],
                    [
                        'name' => $this->owner_name,
                        'email' => $this->email,
                    ]
                );
            }

            DB::commit();
            $this->resetFormReq();
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

    public function resetFormReq()
    {
        // Reset all form fields except these
        $this->resetExcept([
            'receptioners_id', 
            'franchise_id', 
            'technicians', 
            'categories'
        ]);
        
        // Regenerate service code and set estimate delivery
        $this->generateServiceCode();
        $this->estimate_delivery = Carbon::now()->addDays(3)->format('Y-m-d');
        $this->last_update = now();
        $this->status = 0.00;
        $this->amount_paid = 0;
        $this->delivery_status = false;
        
        // Clear any file uploads
        $this->clearImage();
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
        $shops = $franchiseId ? Shop::where('franchise_id', $franchiseId)->get() : Shop::all();
        
        return view('livewire.frontdesk.service-request-form', [
            'technicians' => $technicians,
            'shops' => $shops,
            'categories' => ServiceCategory::all(),
            'brands' => Brand::select('name')->get(),
        ]);
    }
}
