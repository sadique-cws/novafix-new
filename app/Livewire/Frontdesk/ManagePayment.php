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
        $userId = Auth::guard('frontdesk')->user()->id;
        
        // Get all statistics in a single query
        $summary = Payment::where('received_by', $userId)
            ->selectRaw('
                COUNT(*) as total_count,
                SUM(total_amount) as total_amount,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN status = "completed" THEN total_amount ELSE 0 END) as completed_amount,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = "pending" THEN total_amount ELSE 0 END) as pending_amount,
                SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed_count,
                SUM(CASE WHEN status = "failed" THEN total_amount ELSE 0 END) as failed_amount
            ')
            ->first();

        // Calculate percentages
        $totalPaymentCount = $summary->total_count ?? 0;
        $completedPercentage = $totalPaymentCount > 0 ? round(($summary->completed_count / $totalPaymentCount) * 100) : 0;
        $pendingPercentage = $totalPaymentCount > 0 ? round(($summary->pending_count / $totalPaymentCount) * 100) : 0;
        $failedPercentage = $totalPaymentCount > 0 ? round(($summary->failed_count / $totalPaymentCount) * 100) : 0;

        // Get paginated results
        $payments = Payment::with('service')
            ->where('received_by', $userId)
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

        return view('livewire.frontdesk.manage-payment', [
            'payments' => $payments,
            'totalAmount' => $summary->total_amount ?? 0,
            'completedCount' => $summary->completed_count ?? 0,
            'completedAmount' => $summary->completed_amount ?? 0,
            'pendingCount' => $summary->pending_count ?? 0,
            'pendingAmount' => $summary->pending_amount ?? 0,
            'failedCount' => $summary->failed_count ?? 0,
            'failedAmount' => $summary->failed_amount ?? 0,
            'totalPayments' => $payments->total(),
            'completedPercentage' => $completedPercentage,
            'pendingPercentage' => $pendingPercentage,
            'failedPercentage' => $failedPercentage,
        ]);
    }
}