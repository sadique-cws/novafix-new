<?php

namespace App\Livewire\Staff;

use App\Models\Payment;
use App\Models\ServiceRequest;
use App\Models\Ledger;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.staff-layout')]
#[Title('Show Task')]

class ShowTask extends Component
{
    public ServiceRequest $task;
    public $statusOptions = [
        0 => 'Pending',
        1 => 'Processing',
        2 => 'Completed',
        3 => 'Rejected',
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

    public function mount(ServiceRequest $task)
    {
        $this->task = $task->load('receptionist', 'serviceCategory', 'payment');
        $this->selectedStatus = $this->task->status;
        $this->paymentAmount = 0;
        $this->paymentCompleted = $this->task->payment && $this->task->payment->due_amount <= 0;
        $this->taskRejected = $task->status == 90;
    }

    public function rejectTask()
    {
        $this->showRejectionModal = true;
    }

    public function confirmRejection()
    {
        $this->validate([
            'rejectionReason' => 'required|string|max:500'
        ]);

        $this->task->update([
            'status' => 3,
            'last_update' => now(),
            'remark' => $this->rejectionReason
        ]);

        $this->selectedStatus = 3;
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
        if ($this->taskRejected) {
            $this->dispatch(
                'notify',
                type: 'error',
                title: 'Cannot Change Status',
                message: 'Status cannot be changed for rejected tasks'
            );
            $this->selectedStatus = $this->task->status;
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

    public function markAsComplete($id = null)
    {
        $targetId = $id ?? $this->task->id;
        $request = ServiceRequest::find($targetId);
        if ($request) {
            $request->update([
                'status' => 2,
                'last_update' => now()
            ]);
            $this->selectedStatus = 2;
            $this->task->refresh();
            $this->dispatch(
                'notify',
                type: 'success',
                title: 'Task Completed',
                message: 'Task has been marked as completed successfully.'
            );
        }
    }

    public $finalPriceAmount = 0;

    public function openFinalPriceModal()
    {
        $this->finalPriceAmount = $this->task->payment->total_amount ?? 0;
        $this->dispatch('open-modal', 'setFinalPriceModal');
    }

    public function setFinalPrice()
    {
        $this->validate([
            'finalPriceAmount' => 'required|numeric|min:0'
        ]);

        if ($this->task->payment) {
            $new_due = max(0, $this->finalPriceAmount - $this->task->payment->paid_amount);
            $this->task->payment->update([
                'total_amount' => $this->finalPriceAmount,
                'due_amount' => $new_due,
                'status' => ($new_due <= 0 && $this->task->payment->paid_amount >= $this->finalPriceAmount && $this->finalPriceAmount > 0) ? 'completed' : 'partial'
            ]);

            // Wallet/Ledger Logic
            $ledger = Ledger::where('service_request_id', $this->task->id)
                            ->where('type', 'debit')
                            ->first();

            if ($this->finalPriceAmount > 0) {
                if ($ledger) {
                    $ledger->update(['amount' => $this->finalPriceAmount]);
                } else {
                    Ledger::create([
                        'franchise_id' => $this->task->franchise_id,
                        'shop_id' => $this->task->is_shop ? $this->task->shop_id : null,
                        'customer_id' => !$this->task->is_shop ? $this->task->customer_id : null,
                        'service_request_id' => $this->task->id,
                        'type' => 'debit',
                        'amount' => $this->finalPriceAmount,
                        'description' => 'Final Bill for Service ' . $this->task->service_code,
                        'recorded_by' => Auth::guard('staff')->id(),
                        'recorded_by_type' => 'staff'
                    ]);
                }
            } elseif ($ledger) {
                $ledger->delete();
            }

            // Refresh Balance
            if ($this->task->is_shop && $this->task->shop) {
                $this->task->shop->refreshBalance();
            } elseif (!$this->task->is_shop && $this->task->customer) {
                $this->task->customer->refreshBalance();
            }

            $this->dispatch('close-modal', 'setFinalPriceModal');
            $this->dispatch(
                'notify',
                type: 'success',
                title: 'Final Price Updated',
                message: 'Total bill has been updated successfully.'
            );
            $this->task->refresh();
        }
    }

    public function render()
    {
        return view('livewire.staff.show-task', [
            'task' => $this->task->load('receptionist', 'serviceCategory', 'payment')
        ]);
    }
}

