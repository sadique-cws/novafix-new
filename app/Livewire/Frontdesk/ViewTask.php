<?php

namespace App\Livewire\Frontdesk;

use Livewire\Attributes\Layout;
use App\Services\Msg91Service;
use App\Models\Payment;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('View Task')]
#[Layout('components.layouts.frontdesk-layout')]

class ViewTask extends Component
{
    public ServiceRequest $task;
    public $statusOptions = [
        0 => 'Pending',
        25 => 'Processing',
        50 => 'In Repair',
        75 => 'Testing',
        90 => 'Rejected',
        100 => 'Completed'
    ];
    public $selectedStatus;
    public $showPaymentSection = false;
    public $showRejectionModal = false;
    public $rejectionReason = '';
    public $paymentMethod = 'cash';
    public $paymentAmount = 0;
    public $paymentReference = '';
    public $paymentCompleted = false;
    public $taskRejected = false;
    public $otp = '';
    public $showOtpModal = false;
    public $customerMobile = '';
    public $otpSent = false;
    public $otpTimeout = false;
    public $otpExpiresAt;
    public $otpResendAvailable = false;
    public $otpAttempts = 0;
    public $maxOtpAttempts = 3;
    public $countdownSeconds = 60;
    public $otpExpired = false;

    protected Msg91Service $msg91Service;

    public function boot(Msg91Service $msg91Service)
    {
        $this->msg91Service = $msg91Service;
    }

    public function mount(ServiceRequest $task)
    {
        $this->task = $task->load('receptionist', 'serviceCategory', 'payments');
        $this->selectedStatus = $this->task->status;
        $this->paymentAmount = $this->task->payment_amount ?? 0;
        $this->paymentCompleted = $task->payments->isNotEmpty();
        $this->taskRejected = $task->status == 90;
    }

    public function rejectTask()
    {
        if ($this->paymentCompleted) {
            $this->dispatch(
                'notify',
                type: 'error',
                title: 'Cannot Reject',
                message: 'This task already has payments and cannot be rejected'
            );
            return;
        }

        $this->showRejectionModal = true;
    }

    public function confirmRejection()
    {
        $this->validate([
            'rejectionReason' => 'required|string|max:500'
        ]);

        $this->task->update([
            'status' => 90,
            'last_update' => now(),
            'remark' => $this->rejectionReason
        ]);

        $this->selectedStatus = 90;
        $this->taskRejected = true;
        $this->showRejectionModal = false;
        $this->rejectionReason = '';

        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Task Rejected',
            message: 'The task has been rejected successfully'
        );
    }

    public function updateStatus()
    {
        if ($this->paymentCompleted || $this->taskRejected) {
            $this->dispatch(
                'notify',
                type: 'error',
                title: 'Cannot Change Status',
                message: 'Status cannot be changed for ' . ($this->paymentCompleted ? 'completed payments' : 'rejected tasks')
            );
            $this->selectedStatus = $this->task->status;
            return;
        }

        if ($this->selectedStatus == 100) {
            $this->showPaymentSection = true;
            return;
        }

        $this->task->update([
            'status' => $this->selectedStatus,
            'last_update' => now()
        ]);

        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Status Updated',
            message: 'Status changed to: ' . $this->statusOptions[$this->selectedStatus]
        );
    }

    public function completeWithPayment()
    {
        $this->validate([
            'paymentMethod' => 'required|string|in:cash,card,upi',
            'paymentAmount' => 'required|numeric|min:0',
            'paymentReference' => 'nullable|string|max:255',
        ]);

        $taxAmount = 0;
        $discountAmount = 0;
        $totalAmount = $this->paymentAmount + $taxAmount - $discountAmount;

        $payment = Payment::create([
            'service_request_id' => $this->task->id,
            'amount' => $this->paymentAmount,
            'total_amount' => $totalAmount,
            'payment_method' => $this->paymentMethod,
            'transaction_id' => $this->paymentMethod === 'cash' ? 'CASH-' . uniqid() : $this->paymentReference,
            'status' => 'completed',
            'staff_id' => Auth::guard('staff')->user()->id,
            'received_by' => Auth::guard('frontdesk')->user()->id,
            'notes' => $this->paymentReference,
        ]);

        $this->task->update([
            'status' => 100,
        ]);

        $this->paymentCompleted = true;
        $this->showPaymentSection = false;

        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Task Completed!',
            message: 'Payment of ₹' . number_format($totalAmount, 2) . ' recorded (pending verification)',
            duration: 5000
        );
    }
    public function directDelivery(){
        $this->task->update([
            'delivery_status' => 1,
            'delivered_by' => auth('frontdesk')->id(),
        ]);
    }

    public function initiateDelivery()
    {
        $this->validate([
            'task.contact' => 'required|digits:10'
        ]);

        $this->customerMobile = $this->task->contact;

        // Reset OTP state
        $this->otpSent = false;
        $this->otpTimeout = false;
        $this->otpAttempts = 0;
        $this->countdownSeconds = 60;
        $this->otpExpired = false;

        try {
            // Send OTP
            $otpResponse = $this->msg91Service->sendOtp(
                $this->customerMobile,
                $this->task->owner_name ?? 'Customer'
            );

            if ($otpResponse['success']) {
                $this->otpSent = true;
                $this->otpExpiresAt = now()->addSeconds(60);
                $this->showOtpModal = true;

                // Dispatch event to start timer
                $this->dispatch('otp-sent');

                session()->flash('otp-info', 'OTP sent to customer mobile. Valid for 60 seconds.');
            } else {
                session()->flash('otp-error', 'Failed to send OTP. Please try again.');
                Log::error('OTP Send Failed', [
                    'mobile' => $this->customerMobile,
                    'response' => $otpResponse
                ]);
            }
        } catch (\Exception $e) {
            session()->flash('otp-error', 'An error occurred while sending OTP.');
            Log::error('OTP Send Exception', [
                'mobile' => $this->customerMobile,
                'error' => $e->getMessage()
            ]);
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
            $this->task->update([
                'delivery_status' => 1,
                'delivered_by' => auth('frontdesk')->id(),
            ]);

            $this->showOtpModal = false;
            $this->reset(['otp', 'otpSent', 'otpTimeout']);
            $this->task->refresh();

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

    public function otpTimedOut()
    {
        $this->otpTimeout = true;
        session()->flash('otp-error', 'OTP has expired. Please request a new one.');
    }

    public function cancelPayment()
    {
        $this->showPaymentSection = false;
        $this->selectedStatus = $this->task->status;
    }

    public function markAsDelivered()
    {
        $this->task->update([
            'delivery_status' => 1,
            'delivered_by' => auth('frontdesk')->id(),
        ]);

        session()->flash('delivery-success', 'Service request marked as delivered successfully!');
        $this->task->refresh();
    }

    public function render()
    {
        return view('livewire.frontdesk.view-task', [
            'task' => $this->task->load('receptionist', 'serviceCategory', 'payments')
        ]);
    }
}
