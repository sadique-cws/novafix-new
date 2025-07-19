<?php

namespace App\Livewire\Staff;

use App\Models\Payment;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.staff-layout')]
class ShowTask extends Component
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
    public $paymentMethod = 'cash';
    public $paymentAmount = 0;
    public $paymentReference = '';
    public $paymentCompleted = false;

    public $taskRejected = false;

    public function mount(ServiceRequest $task)
    {
        $this->task = $task->load('receptionist', 'serviceCategory', 'payments');
        $this->selectedStatus = $this->task->status;
        $this->paymentAmount = $this->task->payment_amount ?? 0;
        $this->paymentCompleted = $task->payments->isNotEmpty();
        $this->taskRejected = $task->status == 90; // Track if task is rejected
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

        $this->task->update([
            'status' => 90,
            'last_update' => now()
        ]);
        $this->selectedStatus = 90;
        $this->taskRejected = true;

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
            $this->selectedStatus = $this->task->status; // Reset to current status
            return;
        }

        // If Completed, show payment section but don't update yet
        if ($this->selectedStatus == 100) {
            $this->showPaymentSection = true;
            return;
        }

        // For other statuses - update immediately
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

        // Create payment record
        $payment = Payment::create([
            'service_request_id' => $this->task->id,
            'amount' => $this->paymentAmount,
            'discount' => $discountAmount,
            'tax' => $taxAmount,
            'total_amount' => $totalAmount,
            'payment_method' => $this->paymentMethod,
            'transaction_id' => $this->paymentMethod === 'cash' ? 'CASH-' . uniqid() : $this->paymentReference,
            'status' => 'completed',
            'notes' => $this->paymentReference,
            'received_by' => Auth::guard('staff')->user()->id,
        ]);

        // Update service request
        $this->task->update([
            'status' => 100,
            'last_update' => now(),
            'payment_method' => $this->paymentMethod,
            'service_amount' => $totalAmount,
            'completed_at' => now(),
        ]);

        $this->paymentCompleted = true;
        $this->showPaymentSection = false;

        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Payment Successful!',
            message: '₹' . number_format($totalAmount, 2) . ' received via ' .
                ucfirst($this->paymentMethod) .
                ($this->paymentReference ? ' (Ref: ' . $this->paymentReference . ')' : ''),
            duration: 5000
        );
    }

    public function cancelPayment()
    {
        $this->showPaymentSection = false;
        $this->selectedStatus = $this->task->status;
    }

    public function render()
    {
        return view('livewire.staff.show-task', [
            'task' => $this->task->load('receptionist', 'serviceCategory', 'payments')
        ]);
    }
}
