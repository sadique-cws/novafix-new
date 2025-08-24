<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\ServiceRequest;

class ServiceTracker extends Component
{
    public $service_code;
    public $serviceRequest;
    public $notFound = false;

    protected $rules = [
        'service_code' => 'required|string|max:20',
    ];

    public function track()
    {
        $this->validate();

        $this->serviceRequest = ServiceRequest::where('service_code', $this->service_code)
            ->with(['franchise', 'category', 'technician'])
            ->first();

        $this->notFound = !$this->serviceRequest;

        if ($this->notFound) {
            session()->flash('error', 'Service request not found. Please check your service code.');
        }
    }

    public function render()
    {
        return view('livewire.public.service-tracker');
    }
}
