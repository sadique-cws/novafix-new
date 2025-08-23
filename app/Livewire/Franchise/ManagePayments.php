<?php

namespace App\Livewire\Franchise;

use App\Models\Payment;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
#[Title('Manage Payments')]
#[Layout('components.layouts.franchise-layout')]

class ManagePayments extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $statusFilter = ''; // Changed from selectedStatus to match view
    public $paymentMethodFilter = '';
    public $startDate = '';
    public $endDate = '';
    public $showFilters = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'statusFilter' => ['except' => ''],
        'paymentMethodFilter' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

    public function mount()
    {
        // No need to load payment methods here unless for a dropdown
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
        $this->reset(['search', 'statusFilter', 'paymentMethodFilter', 'startDate', 'endDate']);
        $this->resetPage();
    }

    public function getPayments()
    {
        $franchiseId = Auth::guard('franchise')->id();

        return Payment::query()
            ->with(['serviceRequest.receptioner', 'staff'])
            ->whereHas('serviceRequest.receptioner', function ($query) use ($franchiseId) {
                $query->where('franchise_id', $franchiseId);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_id', 'like', '%' . $this->search . '%')
                        ->orWhereHas('serviceRequest', function ($serviceQuery) {
                            $serviceQuery->where('service_code', 'like', '%' . $this->search . '%')
                                ->orWhere('owner_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->paymentMethodFilter, function ($query) {
                $query->where('payment_method', $this->paymentMethodFilter);
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [
                    $this->startDate . ' 00:00:00',
                    $this->endDate . ' 23:59:59'
                ]);
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    public function render()
    {
        $franchiseId = Auth::guard('franchise')->id();

        return view('livewire.franchise.manage-payments', [
            'payments' => $this->getPayments(),
            'totalAmount' => Payment::whereHas('serviceRequest.receptioner', function ($query) use ($franchiseId) {
                $query->where('franchise_id', $franchiseId);
            })
                ->sum('total_amount'),
            'todayAmount' => Payment::whereHas('serviceRequest.receptioner', function ($query) use ($franchiseId) {
                $query->where('franchise_id', $franchiseId);
            })
                ->whereDate('created_at', today())
                ->sum('total_amount'),
        ]);
    }
}
