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

    public $amount = 0;
    public $payment_method = 'cash';
    public $notes = '';
    public $showPaymentModal = false;

    public function recordPayment()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1|max:' . ($this->payment->due_amount ?? 0),
            'payment_method' => 'required'
        ]);

        \App\Models\PaymentTransaction::create([
            'payment_id' => $this->payment->id,
            'service_request_id' => $this->payment->service_request_id,
            'amount_paid' => $this->amount,
            'payment_method' => $this->payment_method,
            'staff_id' => \Illuminate\Support\Facades\Auth::id(),
            'notes' => $this->notes,
        ]);

        $new_paid = $this->payment->paid_amount + $this->amount;
        $new_due = max(0, $this->payment->total_amount - $new_paid);

        $this->payment->update([
            'paid_amount' => $new_paid,
            'due_amount' => $new_due,
            'status' => $new_due <= 0 ? 'completed' : 'partial'
        ]);

        $this->showPaymentModal = false;
        $this->reset(['amount', 'notes']);
        $this->payment->refresh();
        session()->flash('message', 'Payment recorded successfully');
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
