<?php

namespace App\Livewire\Frontdesk;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\ServiceRequest;
use App\Models\ServiceCategory;
use App\Models\Technician;
use Carbon\Carbon;
use Livewire\Attributes\Title;

#[Title('Review Service Request')]
#[Layout('components.layouts.frontdesk-layout')]

class ReviewServiceRequest extends Component
{
    public $serviceRequest;
    public $receiptId;

    public function mount($id)
    {
        $this->receiptId = $id;
        $this->serviceRequest = ServiceRequest::with('serviceCategory')
            ->findOrFail($id);
    }

    public function printReceipt()
    {
        $this->dispatch('printReceipt');
    }

    public function getStatusText($status)
    {
        // Convert decimal status to text
        if ($status == 0.00) return 'pending';
        if ($status == 100.00) return 'completed';
        return 'in progress';
    }

    public function render()
    {
        return view('livewire.frontdesk.review-service-request', [
            'receipt' => $this->serviceRequest,
            'statusText' => $this->getStatusText($this->serviceRequest->status),
            'deliveryDate' => $this->serviceRequest->delivery_status ?
                $this->serviceRequest->updated_at->format('d M Y') : 'Not delivered',
            'generatedDate' => Carbon::now()->format('d F Y'),
        ]);
    }
}