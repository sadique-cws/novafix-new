<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Franchise;
use App\Models\Payment;
use App\Models\ServiceRequest;
use App\Models\ServiceCategory;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Performance')]
#[Layout('components.layouts.admin-layout')]

class Performance extends Component
{
    use WithPagination;

    public $selectedFranchise = 'all';
    public $timePeriod = 'month';
    public $paymentSearch = '';
    public $paymentStatus = 'all';

    protected $queryString = ['selectedFranchise', 'timePeriod', 'paymentStatus'];

    public function render()
    {
        $franchises = Franchise::orderBy('franchise_name')->get();
        $metrics = $this->calculateMetrics();
        $payments = $this->getPaymentData();
        $activities = $this->getRecentActivities();

        return view('livewire.admin.performance', [
            'franchises' => $franchises,
            'metrics' => $metrics,
            'payments' => $payments,
            'activities' => $activities,
        ]);
    }

    protected function calculateMetrics()
    {
        $paymentQuery = Payment::query()
            ->where('status', 'completed')
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('serviceRequest.receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            });

        if ($dateRange = $this->getDateRange()) {
            $paymentQuery->whereBetween('created_at', $dateRange);
        }

        $totalRevenue = $paymentQuery->sum('total_amount');

        $completedServices = ServiceRequest::query()
            ->where('status', 1)
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            })
            ->when($dateRange = $this->getDateRange(), function ($q) use ($dateRange) {
                $q->whereBetween('created_at', $dateRange);
            })
            ->count();

        $totalCustomers = ServiceRequest::query()
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            })
            ->when($dateRange = $this->getDateRange(), function ($q) use ($dateRange) {
                $q->whereBetween('created_at', $dateRange);
            })
          
            ->count('contact');

        return [
            'totalRevenue' => $totalRevenue,
            'completedServices' => $completedServices,
            'totalCustomers' => $totalCustomers,
            'customerRetention' => $this->calculateCustomerRetention(),
        ];
    }

    protected function calculateCustomerRetention()
    {
        $repeatCustomers = ServiceRequest::query()
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            })
            ->when($dateRange = $this->getDateRange(), function ($q) use ($dateRange) {
                $q->whereBetween('created_at', $dateRange);
            })
            ->select('contact')
            ->groupBy('contact')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $totalCustomers = ServiceRequest::query()
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            })
            ->when($dateRange = $this->getDateRange(), function ($q) use ($dateRange) {
                $q->whereBetween('created_at', $dateRange);
            })
            ->distinct('contact')
            ->count('contact');

        $retentionRate = $totalCustomers > 0 ? ($repeatCustomers / $totalCustomers) * 100 : 0;

        return [
            'newCustomers' => $totalCustomers - $repeatCustomers,
            'returningCustomers' => $repeatCustomers,
            'retentionRate' => round($retentionRate, 2),
        ];
    }

    protected function getPaymentData()
    {
        return Payment::query()
            ->with(['serviceRequest.receptioner.franchise', 'serviceRequest.serviceCategory'])
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('serviceRequest.receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            })
            ->when($this->paymentStatus !== 'all', function ($q) {
                $q->where('status', $this->paymentStatus);
            })
            ->when($this->paymentSearch, function ($q) {
                $q->where(function ($query) {
                    $query->where('transaction_id', 'like', '%' . $this->paymentSearch . '%')
                        ->orWhereHas('serviceRequest', function ($q2) {
                            $q2->where('owner_name', 'like', '%' . $this->paymentSearch . '%');
                        });
                });
            })
            ->when($dateRange = $this->getDateRange(), function ($q) use ($dateRange) {
                $q->whereBetween('created_at', $dateRange);
            })
            ->orderByDesc('created_at')
            ->paginate(5);
    }

    protected function getRecentActivities()
    {
        $serviceRequests = ServiceRequest::query()
            ->with(['serviceCategory', 'receptioner.franchise'])
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            })
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'message' => 'New service request: ' . ($item->serviceCategory->name ?? 'Unknown'),
                    'time' => $item->created_at->diffForHumans(),
                    'icon' => 'tools',
                    'color' => 'purple',
                ];
            });

        $payments = Payment::query()
            ->with(['serviceRequest.receptioner.franchise'])
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('serviceRequest.receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            })
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'message' => 'Payment received: ₹' . number_format($item->total_amount, 2),
                    'time' => $item->created_at->diffForHumans(),
                    'icon' => 'money-bill-wave',
                    'color' => 'blue',
                ];
            });

        return $serviceRequests->merge($payments)
            ->sortByDesc('time')
            ->take(5);
    }

    protected function getDateRange()
    {
        $now = Carbon::now();

        switch ($this->timePeriod) {
            case '7days':
                return [$now->copy()->subDays(7), $now];
            case '30days':
                return [$now->copy()->subDays(30), $now];
            case '90days':
                return [$now->copy()->subDays(90), $now];
            case 'month':
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
            case 'quarter':
                return [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()];
            case 'year':
                return [$now->copy()->startOfYear(), $now->copy()->endOfYear()];
            default:
                return null;
        }
    }

    public function updatedSelectedFranchise()
    {
        $this->resetPage();
    }

    public function updatedTimePeriod()
    {
        $this->resetPage();
    }

    public function updatedPaymentStatus()
    {
        $this->resetPage();
    }
}
