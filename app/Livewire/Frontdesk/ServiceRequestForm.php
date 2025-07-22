<?php

namespace App\Livewire\Frontdesk;

use Livewire\Component;
use App\Models\Staff;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Carbon\Carbon;

#[Layout('components.layouts.frontdesk-layout')]
class ServiceRequestForm extends Component
{
    use WithFileUploads;

    // Form fields
    #[Rule('nullable|exists:staff,id')]
    public $technician_id;

    #[Rule('required|exists:service_categories,id')]
    public $service_categories_id;

    public $service_code;

    #[Rule('required|string|max:255')]
    public $owner_name;

    #[Rule('required|string|max:255')]
    public $product_name;

    #[Rule('nullable|email')]
    public $email;

    #[Rule('required|string|max:20')]
    public $contact;

    #[Rule('required|string|max:255')]
    public $brand;

    #[Rule('nullable|string|max:255')]
    public $serial_no;

    #[Rule('nullable|string|max:255')]
    public $MAC;

    #[Rule('required|string|max:100')]
    public $color;

    #[Rule('nullable|numeric|min:0')]
    public $service_amount = 0.00;

    #[Rule('required|string')]
    public $problem;

    #[Rule('nullable|string')]
    public $remark;

    #[Rule('nullable|numeric')]
    public $status = 0.00;

    #[Rule('nullable|date')]
    public $last_update;

    #[Rule('nullable|string|max:255')]
    public $delivered_by;

    #[Rule('nullable|date|after:today')]
    public $estimate_delivery;

    #[Rule('nullable|date')]
    public $date_of_delivery;

    #[Rule('nullable|image|max:2048')]
    public $image;

    public function mount()
    {
        $this->last_update = now()->format('Y-m-d\TH:i');
        $this->estimate_delivery = Carbon::now()->addDays(3)->format('Y-m-d\TH:i');
        $this->generateServiceCode();
    }

    protected function generateServiceCode()
    {
        $latestRequest = ServiceRequest::latest()->first();
        $this->service_code = $latestRequest
            ? 'SR-' . str_pad((int) substr($latestRequest->service_code, 3) + 1, 5, '0', STR_PAD_LEFT)
            : 'SR-00001';
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->image) {
            $validated['image'] = $this->image->store('service-requests', 'public');
        }

        $validated['receptioners_id'] = Auth::guard('frontdesk')->user()->id;

        if (empty($validated['service_code'])) {
            $this->generateServiceCode();
            $validated['service_code'] = $this->service_code;
        }

        ServiceRequest::create($validated);

        $this->resetForm();

        session()->flash('success', 'Service request created successfully!');
        $this->redirect(
            route('frontdesk.servicerequest.manage'),
            navigate: true
        );
    }

    protected function resetForm()
    {
        $this->resetExcept(['technicians', 'categories']);
        $this->last_update = now()->format('Y-m-d\TH:i');
        $this->estimate_delivery = Carbon::now()->addDays(3)->format('Y-m-d\TH:i');
        $this->status = 0.00;
        $this->generateServiceCode();
    }

    public function render()
    {
        return view('livewire.frontdesk.service-request-form', [
            'technicians' => Staff::all(),
            'categories' => ServiceCategory::all(),
        ]);
    }
}
