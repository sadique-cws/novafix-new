<?php

namespace App\Livewire\Frontdesk;

use App\Models\ServiceRequest;
use App\Models\Payment;
use App\Services\Msg91Service;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('Show Completed Task')]
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
    public $showOtpModal = false;
    public $otp = '';

    public $customerMobile = '';
    public $otpSent = false;
    public $otpTimeout = false;
    public $otpExpiresAt;
    public $otpResendAvailable = false;
    public $otpAttempts = 0;
    public $maxOtpAttempts = 3;
    public $countdownSeconds ;

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
    protected $msg91Service;

    public function __construct()
    {
        $this->msg91Service = app(Msg91Service::class);
    }

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
            'status' => '100' // Assuming 100 means completed
        ]);

        $this->request->refresh();
        $this->loadLatestPayment();
        session()->flash('payment-success', $message);
    }
    public function directDelivery()
    {
        $this->request->update([
            'delivery_status' => 1,
            'delivered_by' => auth('frontdesk')->id(),
        ]);
    }

    public function initiateDelivery(Msg91Service $msg91Service)
    {
        $this->validate([
            'request.contact' => 'required|digits:10'
        ]);

        $this->customerMobile = $this->request->contact;

        // Reset OTP state
        $this->otpSent = false;
        $this->otpTimeout = false;
        $this->otpAttempts = 0;
        $this->countdownSeconds = 60;

        // Send OTP
        $otpResponse = $msg91Service->sendOtp(
            $this->customerMobile,
            $this->request->owner_name ?? 'Customer'
        );

        if ($otpResponse['success']) {
            $this->otpSent = true;
            $this->otpExpiresAt = now()->addSeconds(60);
            $this->otpTimeout = false;
            $this->showOtpModal = true;

           
            $this->dispatch('start-otp-timer', expiresAt: now()->addSeconds(60)->timestamp);
            session()->flash('otp-info', 'OTP sent to customer mobile. Valid for 60 seconds.');
        } else {
            session()->flash('otp-error', 'Failed to send OTP. Please try again.');
            Log::error('OTP Send Failed', ['response' => $otpResponse]);
        }
    }

    public function verifyOtpAndMarkDelivered()
    {
        $this->validate(['otp' => 'required|digits:6']);

        // Check if OTP is expired
        if (now()->gt($this->otpExpiresAt)) {
            session()->flash('otp-error', 'OTP has expired. Please request a new one.');
            $this->otpTimeout = true;
            return;
        }

        // Check max attempts
        if ($this->otpAttempts >= $this->maxOtpAttempts) {
            session()->flash('otp-error', 'Maximum OTP attempts reached. Please request a new OTP.');
            $this->otpTimeout = true;
            return;
        }

        $this->otpAttempts++;

        $verificationResponse = $this->msg91Service->verifyOtp(
            $this->customerMobile,
            $this->otp
        );

        if ($verificationResponse['success']) {
            // Mark as delivered
            $this->request->update([
                'delivery_status' => 1,
                'delivered_by' => auth('frontdesk')->id(),
            ]);

            $this->showOtpModal = false;
            $this->reset(['otp', 'otpSent', 'otpTimeout']);
            $this->request->refresh();

            session()->flash('delivery-success', 'Service marked as delivered successfully!');
        } else {
            $remainingAttempts = $this->maxOtpAttempts - $this->otpAttempts;
            $message = 'Invalid OTP.';
            if ($remainingAttempts > 0) {
                $message .= " {$remainingAttempts} attempts remaining.";
            } else {
                $message .= " No attempts remaining.";
                $this->otpTimeout = true;
            }

            session()->flash('otp-error', $message);
            Log::error('OTP Verification Failed', [
                'mobile' => $this->customerMobile,
                'response' => $verificationResponse
            ]);
        }
    }
    
    // Add this method to handle OTP timeout
    public function otpTimedOut()
    {
        $this->otpTimeout = true;
        session()->flash('otp-error', 'OTP has expired. Please request a new one.');
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
    $this->payment_method = 'cash'; // Set default
    $this->status = 'completed'; // Set default
    $this->calculateTotal();
}

    public function render()
    {
        return view('livewire.frontdesk.show-completed-task');
}}