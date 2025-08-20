<?php

namespace App\Livewire\Frontdesk;

use App\Models\Payment;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Title('View Payments')]
#[Layout('components.layouts.frontdesk-layout')]

class ViewPayments extends Component

{
    public $serviceRequest;
    public $payment;
    public $serviceCode;

    public function mount($serviceCode)
    {
        $this->serviceCode = $serviceCode;
        $this->loadData();
    }

    public function loadData()
    {
        $this->serviceRequest = ServiceRequest::where('service_code', $this->serviceCode)
            ->with(['payments', 'serviceCategory'])
            ->firstOrFail();

        $this->payment = $this->serviceRequest->payments->first();
    }

    public function render()
    {
        return view('livewire.frontdesk.view-payments');
            
    }
}
