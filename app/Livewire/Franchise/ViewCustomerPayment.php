<?php

namespace App\Livewire\Franchise;

use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('View Customer Payment')]
#[Layout('components.layouts.franchise-layout')]

class ViewCustomerPayment extends Component
{
    public Payment $payment;

    public function mount($paymentId)
    {
        $this->payment = Payment::with([
            'serviceRequest.serviceCategory',
            'serviceRequest.receptioner',
            'receivedBy'
        ])->findOrFail($paymentId);
    }

    public function markAsPaid($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update(['status' => 'completed']);

        session()->flash('message', 'Payment marked as completed successfully');
    }

    public function printReceipt($paymentId)
    {
        return redirect()->route('franchise.payments.receipt', ['payment' => $paymentId]);
    }

    public function render()
    {
        return view('livewire.franchise.view-customer-payment');
    }
}
