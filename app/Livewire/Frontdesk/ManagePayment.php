<?php

namespace App\Livewire\Frontdesk;

use App\Models\Payment;
use App\Models\Service;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
#[Title('Manage Payment')]
#[Layout('components.layouts.frontdesk-layout')]

class ManagePayment extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $statusFilter = 'all';

    #[Url]
    public $methodFilter = 'all';

    #[Url]
    public $dateFilter = '';

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'methodFilter', 'dateFilter']);
        $this->resetPage();
    }

    public function render()
    {
        $payments = Payment::with('service')
            ->where('received_by', Auth::guard('frontdesk')->user()->id)
            ->when($this->search, function ($query) {
                $query->whereHas('service', function ($q) {
                    $q->where('service_code', 'like', '%' . $this->search . '%')
                        ->orWhere('owner_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->methodFilter !== 'all', function ($query) {
                $query->where('payment_method', $this->methodFilter);
            })
            ->when($this->dateFilter, function ($query) {
                $query->whereDate('created_at', $this->dateFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate summary statistics
        $totalAmount = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)
            ->sum('total_amount');

        $completedCount = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)
            ->where('status', 'completed')
            ->count();

        $completedAmount = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)
            ->where('status', 'completed')
            ->sum('total_amount');

        $pendingCount = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)
            ->where('status', 'pending')
            ->count();

        $pendingAmount = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)
            ->where('status', 'pending')
            ->sum('total_amount');

        $failedCount = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)
            ->where('status', 'failed')
            ->count();

        $failedAmount = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)
            ->where('status', 'failed')
            ->sum('total_amount');

        // Calculate total payment count for percentages
        $totalPaymentCount = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)->count();

        // Calculate percentages (avoid division by zero)
        $completedPercentage = $totalPaymentCount > 0 ? round(($completedCount / $totalPaymentCount) * 100) : 0;
        $pendingPercentage = $totalPaymentCount > 0 ? round(($pendingCount / $totalPaymentCount) * 100) : 0;
        $failedPercentage = $totalPaymentCount > 0 ? round(($failedCount / $totalPaymentCount) * 100) : 0;

        return view('livewire.frontdesk.manage-payment', [
            'payments' => $payments,
            'totalAmount' => $totalAmount,
            'completedCount' => $completedCount,
            'completedAmount' => $completedAmount,
            'pendingCount' => $pendingCount,
            'pendingAmount' => $pendingAmount,
            'failedCount' => $failedCount,
            'failedAmount' => $failedAmount,
            'totalPayments' => $payments->total(),
            'completedPercentage' => $completedPercentage,
            'pendingPercentage' => $pendingPercentage,
            'failedPercentage' => $failedPercentage,
        ]);
    }
}
