<?php

namespace App\Livewire\Frontdesk;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\ServiceRequest;
use App\Models\ServiceCategory;
use App\Models\Technician;
#[Title('Review Service Request')]
#[Layout('components.layouts.frontdesk-layout')]

class ReviewServiceRequest extends Component
{
    public $serviceRequest;
    public $serviceCategory;
    public $technician;

    public function mount($id)
    {
        $this->serviceRequest = ServiceRequest::with(['serviceCategory', 'technician'])
            ->findOrFail($id);
            
        $this->serviceCategory = $this->serviceRequest->category;
        $this->technician = $this->serviceRequest->technician;
    }

    public function printReceipt()
    {
        $this->dispatchBrowserEvent('print-receipt');
    }

    public function render()
    {
        return view('livewire.frontdesk.review-service-request');
    }
}