<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Franchise;
use App\Models\franchises;
use App\Models\Payment;
use App\Models\ServiceRequest;
use App\Models\Staff;
use App\Models\Receptioner;
use App\Models\ServiceCategory;
use Livewire\WithPagination;
use Carbon\Carbon;

#[Layout('components.layouts.admin-layout')]
class Performance extends Component
{
    use WithPagination;

    public $selectedFranchise = 'all';
    public $timePeriod = 'month';
    public $paymentSearch = '';
    public $paymentStatus = 'all';
    public $chartUpdateKey = 0; // Add this for chart updates

    protected $queryString = ['selectedFranchise', 'timePeriod', 'paymentStatus'];

    protected function getListeners()
    {
        return [
            'updateCharts' => 'updateCharts',
        ];
    }

    public function updateCharts()
    {
        $this->chartUpdateKey++;
    }

    public function render()
    {
        // Get base query for franchises
        $franchises = franchises::orderBy('franchise_name')->get();

        // Get data based on selected franchise
        $query = $this->getBaseQuery();

        // Payment data
        $payments = $this->getPaymentData();

        // Calculate metrics
        $metrics = $this->calculateMetrics($query);

        // Get recent activities
        $activities = $this->getRecentActivities();

        return view('livewire.admin.performance', [
            'franchises' => $franchises,
            'metrics' => $metrics,
            'payments' => $payments,
            'activities' => $activities,
            'revenueTrendData' => $this->getRevenueTrendData(),
            'serviceDistributionData' => $this->getServiceDistributionData(),
        ]);
    }

    protected function getBaseQuery()
    {
        $query = ServiceRequest::query()
            ->with(['serviceCategory', 'technician', 'receptioner.franchise', 'payments']);

        if ($this->selectedFranchise !== 'all') {
            $query->whereHas('receptioner.franchise', function ($q) {
                $q->where('id', $this->selectedFranchise);
            });
        }

        $dateRange = $this->getDateRange();
        if ($dateRange) {
            $query->whereBetween('created_at', $dateRange);
        }

        return $query;
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

    protected function calculateMetrics($query)
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

        $completedServices = $query->clone()
            ->where('status', 1)
            ->count();

        $totalCustomers = $query->clone()
            ->distinct('contact')
            ->count('contact');

        return [
            'totalRevenue' => $totalRevenue,
            'completedServices' => $completedServices,
            'totalCustomers' => $totalCustomers,
            'customerRetention' => $this->calculateCustomerRetention($query),
            'staffPerformance' => $this->getStaffPerformance(),
            'financialHealth' => $this->getFinancialHealth(),
        ];
    }

    protected function calculateCustomerRetention($query)
    {
        $repeatCustomers = $query->clone()
            ->select('contact')
            ->groupBy('contact')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $totalCustomers = $query->clone()
            ->distinct('contact')
            ->count('contact');

        $retentionRate = $totalCustomers > 0 ? ($repeatCustomers / $totalCustomers) * 100 : 0;

        return [
            'newCustomers' => $totalCustomers - $repeatCustomers,
            'returningCustomers' => $repeatCustomers,
            'retentionRate' => round($retentionRate, 2),
        ];
    }

    protected function getStaffPerformance()
    {
        $query = Staff::query()
            ->withCount(['serviceRequests' => function ($q) {
                if ($this->selectedFranchise !== 'all') {
                    $q->whereHas('receptioner.franchise', function ($q2) {
                        $q2->where('franchise_id', $this->selectedFranchise);
                    });
                }
                if ($dateRange = $this->getDateRange()) {
                    $q->whereBetween('created_at', $dateRange);
                }
            }]);

        $topPerformer = $query->clone()
            ->orderByDesc('service_requests_count')
            ->first();

        $avgServices = $query->clone()
            ->has('serviceRequests')
            ->get()
            ->avg('service_requests_count');

        return [
            'avgServicesPerStaff' => round($avgServices ?? 0, 1),
            'topPerformer' => $topPerformer ? $topPerformer->name . ' (' . $topPerformer->service_requests_count . ')' : 'N/A',
        ];
    }

    protected function getFinancialHealth()
    {
        $query = Payment::query()
            ->where('status', 'completed');

        if ($this->selectedFranchise !== 'all') {
            $query->whereHas('serviceRequest.receptioner.franchise', function ($q) {
                $q->where('id', $this->selectedFranchise);
            });
        }

        if ($dateRange = $this->getDateRange()) {
            $query->whereBetween('created_at', $dateRange);
        }

        $totalRevenue = $query->sum('total_amount');
        $days = $this->getDaysInPeriod();

        return [
            'profitMargin' => 32.5,
            'avgRevenuePerDay' => $days > 0 ? round($totalRevenue / $days, 2) : 0,
            'expenseRatio' => 42.1,
        ];
    }

    protected function getDaysInPeriod()
    {
        $range = $this->getDateRange();
        if (!$range) return 30;

        return Carbon::parse($range[0])->diffInDays(Carbon::parse($range[1])) + 1;
    }

    protected function getPaymentData()
    {
        $query = Payment::query()
            ->with(['serviceRequest.receptioner.franchise', 'staff', 'receivedBy'])
            ->orderByDesc('created_at');

        if ($this->selectedFranchise !== 'all') {
            $query->whereHas('serviceRequest.receptioner.franchise', function ($q) {
                $q->where('id', $this->selectedFranchise);
            });
        }

        if ($this->paymentStatus !== 'all') {
            $query->where('status', $this->paymentStatus);
        }

        if ($this->paymentSearch) {
            $query->where(function ($q) {
                $q->where('transaction_id', 'like', '%' . $this->paymentSearch . '%')
                    ->orWhereHas('serviceRequest', function ($q2) {
                        $q2->where('owner_name', 'like', '%' . $this->paymentSearch . '%')
                            ->orWhere('service_code', 'like', '%' . $this->paymentSearch . '%');
                    });
            });
        }

        if ($dateRange = $this->getDateRange()) {
            $query->whereBetween('created_at', $dateRange);
        }

        return $query->paginate(5);
    }

    protected function getRecentActivities()
    {
        $serviceRequestQuery = ServiceRequest::query()
            ->with(['serviceCategory', 'receptioner.franchise'])
            ->latest();

        $paymentQuery = Payment::query()
            ->with(['serviceRequest.receptioner.franchise'])
            ->latest();

        if ($this->selectedFranchise !== 'all') {
            $serviceRequestQuery->whereHas('receptioner.franchise', function ($q) {
                $q->where('id', $this->selectedFranchise);
            });
            $paymentQuery->whereHas('serviceRequest.receptioner.franchise', function ($q) {
                $q->where('id', $this->selectedFranchise);
            });
        }

        $serviceRequests = $serviceRequestQuery->take(3)->get()
            ->map(function ($item) {
                return [
                    'type' => 'service',
                    'message' => 'New service request: ' . ($item->serviceCategory->name ?? 'Unknown'),
                    'time' => $item->created_at->diffForHumans(),
                    'icon' => 'tools',
                    'color' => 'purple',
                ];
            });

        $payments = $paymentQuery->take(3)->get()
            ->map(function ($item) {
                return [
                    'type' => 'payment',
                    'message' => 'Payment received: $' . number_format($item->total_amount, 2),
                    'time' => $item->created_at->diffForHumans(),
                    'icon' => 'money-bill-wave',
                    'color' => 'blue',
                ];
            });

        return $serviceRequests->merge($payments)
            ->sortByDesc('time')
            ->take(5);
    }

    protected function getRevenueTrendData()
    {
        $range = $this->getDateRange();
        $start = $range ? Carbon::parse($range[0]) : Carbon::now()->subDays(30);
        $end = $range ? Carbon::parse($range[1]) : Carbon::now();

        $data = [];
        $labels = [];

        $paymentQuery = Payment::query()
            ->where('status', 'completed')
            ->when($this->selectedFranchise !== 'all', function ($q) {
                $q->whereHas('serviceRequest.receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            });

        if ($this->timePeriod === 'month' || $this->timePeriod === 'year') {
            $current = $start->copy();
            while ($current <= $end) {
                $month = $current->format('M Y');
                $labels[] = $month;

                $total = $paymentQuery->clone()
                    ->whereYear('created_at', $current->year)
                    ->whereMonth('created_at', $current->month)
                    ->sum('total_amount');

                $data[] = $total;
                $current->addMonth();
            }
        } else {
            $current = $start->copy();
            while ($current <= $end) {
                $labels[] = $current->format('M j');

                $total = $paymentQuery->clone()
                    ->whereDate('created_at', $current->toDateString())
                    ->sum('total_amount');

                $data[] = $total;
                $current->addDay();
            }
        }

        return [
            'labels' => $labels ?: ['No data'],
            'data' => $data ?: [0],
        ];
    }

    protected function getServiceDistributionData()
    {
        $services = ServiceCategory::withCount(['serviceRequests' => function ($q) {
            if ($this->selectedFranchise !== 'all') {
                $q->whereHas('receptioner.franchise', function ($q2) {
                    $q2->where('id', $this->selectedFranchise);
                });
            }
            if ($dateRange = $this->getDateRange()) {
                $q->whereBetween('created_at', $dateRange);
            }
        }])
            ->orderByDesc('service_requests_count')
            ->get();

        if ($services->isEmpty()) {
            return [
                'labels' => ['No services'],
                'data' => [1],
            ];
        }

        return [
            'labels' => $services->pluck('name')->toArray(),
            'data' => $services->pluck('service_requests_count')->toArray(),
        ];
    }

    public function updatedSelectedFranchise()
    {
        $this->resetPage();
        $this->updateCharts();
    }

    public function updatedTimePeriod()
    {
        $this->resetPage();
        $this->updateCharts();
    }

    public function updatedPaymentStatus()
    {
        $this->resetPage();
    }
}
