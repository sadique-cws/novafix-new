<?php

namespace App\Livewire\Frontdesk;

use App\Models\ServiceRequest;
use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.frontdesk-layout')]
class ShowCompletedTask extends Component
{
    public $requestId;
    public ServiceRequest $request;
    public $showPaymentForm = false;
    public $editingPaymentId = null;

    // Payment form fields
    public $amount;
    public $discount = 0;
    public $tax = 0;
    public $total_amount = 0;
    public $payment_method = 'cash';
    public $transaction_id = '';
    public $notes = '';
    public $status = 'completed';

    protected $rules = [
        'amount' => 'required|numeric|min:0',
        'discount' => 'numeric|min:0',
        'tax' => 'numeric|min:0',
        'total_amount' => 'numeric|min:0',
        'payment_method' => 'required|in:cash,card,transfer',
        'transaction_id' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'status' => 'required|in:pending,completed,failed',
    ];

    public function mount($requestId)
    {
        $this->request = ServiceRequest::with(['technician', 'receptionist', 'payments'])
            ->findOrFail($requestId);
        $this->loadLatestPayment();
    }

    public function loadLatestPayment()
    {
        $payment = $this->request->payments->last();

        if ($payment) {
            $this->editingPaymentId = $payment->id;
            $this->amount = $payment->amount;
            $this->discount = $payment->discount;
            $this->tax = $payment->tax;
            $this->total_amount = $payment->total_amount;
            $this->payment_method = $payment->payment_method;
            $this->transaction_id = $payment->transaction_id;
            $this->notes = $payment->notes;
            $this->status = $payment->status;

            $this->showPaymentForm = $payment->status !== 'completed';
        } else {
            $this->amount = $this->request->estimated_cost ?? 0;
            $this->resetPaymentForm();
            $this->showPaymentForm = true;
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total_amount = max(0, $this->amount - $this->discount + $this->tax);
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['amount', 'discount', 'tax'])) {
            $this->calculateTotal();
        }
    }

    public function savePayment()
    {
        $this->validate();

        $paymentData = [
            'service_request_id' => $this->request->id,
            'amount' => $this->amount,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total_amount' => $this->total_amount,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'status' => $this->status,
            'notes' => $this->notes,
            'received_by' => auth('frontdesk')->id(),
        ];

        if ($this->editingPaymentId) {
            Payment::find($this->editingPaymentId)->update($paymentData);
            $message = 'Payment updated successfully!';
        } else {
            Payment::create($paymentData);
            $message = 'Payment recorded successfully!';
        }

        // Update service request with payment information
        $this->request->update([
            'service_amount' => $this->amount,
            'status' => '100' // Assuming 100 means completed
        ]);

        $this->request->refresh();
        $this->loadLatestPayment();
        session()->flash('payment-success', $message);
    }

    public function markAsDelivered()
    {
        $this->request->update([
            'delivery_status' => 1,
            'delivered_by' => auth('frontdesk')->id(),
            'delivered_at' => now(),
        ]);

        session()->flash('delivery-success', 'Service request marked as delivered successfully!');
        $this->request->refresh();
    }

    public function resetPaymentForm()
    {
        $this->reset([
            'amount',
            'discount',
            'tax',
            'total_amount',
            'payment_method',
            'transaction_id',
            'notes',
            'status',
            'editingPaymentId'
        ]);
        $this->amount = $this->request->estimated_cost ?? 0;
        $this->calculateTotal();
    }

    public function render()
    {
        return view('livewire.frontdesk.show-completed-task');
    }
}
