<?php

namespace App\Livewire\Franchise;

use App\Models\Payment;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.franchise-layout')]
class ManagePayments extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedStatus = '';
    public $paymentMethods = [];
    public $dateRange = '';
    public $showFilters = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'selectedStatus' => ['except' => ''],
        'dateRange' => ['except' => ''],
    ];

    public function mount()
    {
        $this->paymentMethods = Payment::distinct()
            ->where('franchise_id', Auth::user()->franchise_id)
            ->pluck('payment_method')
            ->toArray();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedStatus = '';
        $this->dateRange = '';
        $this->resetPage();
    }

    public function getPayments()
    {
        return Payment::query()
            ->with(['serviceRequest', 'staff'])
            ->where('franchise_id', Auth::user()->franchise_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_id', 'like', '%' . $this->search . '%')
                        ->orWhereHas('serviceRequest', function ($serviceQuery) {
                            $serviceQuery->where('service_code', 'like', '%' . $this->search . '%')
                                ->orWhere('owner_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->selectedStatus, function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->when($this->dateRange, function ($query) {
                $dates = explode(' to ', $this->dateRange);
                $query->whereDate('created_at', '>=', $dates[0])
                    ->whereDate('created_at', '<=', $dates[1] ?? $dates[0]);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.franchise.manage-payments', [
            'payments' => $this->getPayments(),
            'totalAmount' => Payment::where('franchise_id', Auth::user()->franchise_id)
                ->sum('total_amount'),
            'todayAmount' => Payment::where('franchise_id', Auth::user()->franchise_id)
                ->whereDate('created_at', today())
                ->sum('total_amount'),
        ]);
    }
}
