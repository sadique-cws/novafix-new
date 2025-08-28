<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\ServiceRequest;

class ReceiptRequest extends Component
{
    public $serviceRequest;
    public function mount($id)
    {
        $this->serviceRequest = ServiceRequest::findOrFail($id);
    }
    public function printReceipt()
    {
        $this->dispatch('printReceipt');
    }

    public function render()
    {
        return view('livewire.public.receipt-request', [
            'serviceRequest' => $this->serviceRequest,
        ]);
    }
}
