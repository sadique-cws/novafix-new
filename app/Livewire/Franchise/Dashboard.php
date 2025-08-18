<?php

namespace App\Livewire\Franchise;

use App\Models\Franchise;
use App\Models\Payment;
use App\Models\Receptioners;
use App\Models\ServiceRequest;
use App\Models\ServiceCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.franchise-layout')]
class Dashboard extends Component
{
    public $franchiseId;
    public $timeRange = 'monthly';
    public $performanceFilter = 'Top Performing';
    public $revenueChartType = 'line';
    public $selectedYear;

    public function mount()
    {
        $this->franchiseId = Auth::guard('franchise')->user()->id;
        $this->selectedYear = date('Y');
    }

    public function render()
    {
        $stats = $this->getStats();
        $revenueData = $this->getRevenueData();
        $performanceData = $this->getPerformanceData();
        $recentOrders = $this->getRecentOrders();
        $years = $this->getAvailableYears();

        return view('livewire.franchise.dashboard', [
            'stats' => $stats,
            'revenueData' => $revenueData,
            'performanceData' => $performanceData,
            'recentOrders' => $recentOrders,
            'years' => $years,
        ]);
    }

    protected function getStats()
    {
        $franchiseId = Auth::guard('franchise')->id();
        $receptionerIds = Receptioners::where('franchise_id', $franchiseId)->pluck('id');

        // Current month stats
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        // Previous month stats
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Total customers (current month)
        $currentMonthCustomers = ServiceRequest::whereIn('receptioners_id', $receptionerIds)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->distinct('contact')
            ->count('contact');

        // Previous month customers for percentage calculation
        $previousMonthCustomers = ServiceRequest::whereIn('receptioners_id', $receptionerIds)
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->distinct('contact')
            ->count('contact');

        $customerPercentageChange = $previousMonthCustomers > 0
            ? round((($currentMonthCustomers - $previousMonthCustomers) / $previousMonthCustomers) * 100, 2)
            : 100;

        // Services completed (current month)
        $currentMonthServices = ServiceRequest::whereIn('receptioners_id', $receptionerIds)
            ->where('status', '100') // Completed status
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        // Previous month services for percentage calculation
        $previousMonthServices = ServiceRequest::whereIn('receptioners_id', $receptionerIds)
            ->where('status', '100')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $servicesPercentageChange = $previousMonthServices > 0
            ? round((($currentMonthServices - $previousMonthServices) / $previousMonthServices) * 100, 2)
            : 100;

        // Total revenue (current month)
        $currentMonthRevenue = Payment::whereHas('serviceRequest', function ($query) use ($receptionerIds, $currentMonthStart, $currentMonthEnd) {
            $query->whereIn('receptioners_id', $receptionerIds)
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd]);
        })
            ->where('status', 'completed')
            ->sum('total_amount');

        // Previous month revenue for percentage calculation
        $previousMonthRevenue = Payment::whereHas('serviceRequest', function ($query) use ($receptionerIds, $previousMonthStart, $previousMonthEnd) {
            $query->whereIn('receptioners_id', $receptionerIds)
                ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd]);
        })
            ->where('status', 'completed')
            ->sum('total_amount');

        $revenuePercentageChange = $previousMonthRevenue > 0
            ? round((($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100, 2)
            : 100;

        // Total receptionists
        $totalReceptionists = Receptioners::where('franchise_id', $franchiseId)->count();

        return [
            'totalReceptionists' => $totalReceptionists,
            'totalCustomers' => ServiceRequest::whereIn('receptioners_id', $receptionerIds)
                ->distinct('contact')
                ->count('contact'),
            'servicesCompleted' => ServiceRequest::whereIn('receptioners_id', $receptionerIds)
                ->where('status', '100') // Completed status
                ->count(),
            'totalRevenue' => Payment::whereHas('serviceRequest', function ($query) use ($receptionerIds) {
                $query->whereIn('receptioners_id', $receptionerIds);
            })
                ->where('status', 'completed')
                ->sum('total_amount'),
            'customerPercentageChange' => $customerPercentageChange,
            'servicesPercentageChange' => $servicesPercentageChange,
            'revenuePercentageChange' => $revenuePercentageChange,
            'currentMonthRevenue' => $currentMonthRevenue,
        ];
    }

    protected function getRevenueData()
    {
        $receptionerIds = $this->getFranchiseReceptionerIds();

        if ($this->timeRange === 'monthly') {
            $data = Payment::selectRaw('
                    MONTH(payments.created_at) as month,
                    SUM(payments.total_amount) as revenue
                ')
                ->join('service_requests', 'payments.service_request_id', '=', 'service_requests.id')
                ->whereIn('service_requests.receptioners_id', $receptionerIds)
                ->where('payments.status', 'completed')
                ->whereYear('payments.created_at', $this->selectedYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $values = array_fill(0, 12, 0);

            foreach ($data as $item) {
                $values[$item->month - 1] = $item->revenue;
            }
        } else {
            // Yearly data - last 5 years including current year
            $currentYear = date('Y');
            $startYear = $currentYear - 4;

            $data = Payment::selectRaw('
                    YEAR(payments.created_at) as year,
                    SUM(payments.total_amount) as revenue
                ')
                ->join('service_requests', 'payments.service_request_id', '=', 'service_requests.id')
                ->whereIn('service_requests.receptioners_id', $receptionerIds)
                ->where('payments.status', 'completed')
                ->whereBetween(DB::raw('YEAR(payments.created_at)'), [$startYear, $currentYear])
                ->groupBy('year')
                ->orderBy('year')
                ->get();

            $labels = [];
            $values = [];

            for ($i = $startYear; $i <= $currentYear; $i++) {
                $labels[] = $i;
                $values[] = $data->where('year', $i)->first()->revenue ?? 0;
            }
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    protected function getPerformanceData()
    {
        $receptionerIds = $this->getFranchiseReceptionerIds();

        $query = ServiceRequest::selectRaw('
                service_categories.name as service_name,
                COUNT(service_requests.id) as request_count,
                SUM(payments.total_amount) as total_revenue
            ')
            ->join('service_categories', 'service_requests.service_categories_id', '=', 'service_categories.id')
            ->leftJoin('payments', function ($join) {
                $join->on('service_requests.id', '=', 'payments.service_request_id')
                    ->where('payments.status', 'completed');
            })
            ->whereIn('service_requests.receptioners_id', $receptionerIds);

        // Apply filters based on performance selection
        if ($this->performanceFilter === 'Top Performing') {
            $query->orderBy('total_revenue', 'desc');
        } elseif ($this->performanceFilter === 'Low Performing') {
            $query->orderBy('total_revenue', 'asc');
        } else {
            // Mid performing - get services in the middle range
            $query->orderBy('total_revenue', 'desc');
        }

        $services = $query->groupBy('service_categories.name')
            ->limit(5)
            ->get();

        // For mid performing, we'll take the middle items
        if ($this->performanceFilter === 'Mid Performing' && $services->count() > 2) {
            $services = $services->slice(1, -1)->values();
        }

        $labels = $services->pluck('service_name')->toArray();
        $values = $services->pluck('total_revenue')->toArray();

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    protected function getRecentOrders()
    {
        $receptionerIds = $this->getFranchiseReceptionerIds();

        return ServiceRequest::with(['payment', 'serviceCategory'])
            ->whereIn('receptioners_id', $receptionerIds)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->service_code,
                    'customer' => $order->owner_name,
                    'service' => $order->serviceCategory->name,
                    'status' => $this->getStatusInfo($order->status),
                    'amount' => $order->payment ? $order->payment->total_amount : 0,
                    'date' => $order->created_at->format('M d, Y H:i'),
                ];
            });
    }

    protected function getAvailableYears()
    {
        $receptionerIds = $this->getFranchiseReceptionerIds();

        return Payment::selectRaw('YEAR(payments.created_at) as year')
            ->join('service_requests', 'payments.service_request_id', '=', 'service_requests.id')
            ->whereIn('service_requests.receptioners_id', $receptionerIds)
            ->where('payments.status', 'completed')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
    }

    protected function getFranchiseReceptionerIds()
    {
        return Receptioners::where('franchise_id', $this->franchiseId)
            ->pluck('id')
            ->toArray();
    }

    protected function getStatusInfo($status)
    {
        $statuses = [
            '100' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Completed'],
            '50' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'In Progress'],
            '90' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Cancelled'],
            '0' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pending'],
            '10' => ['class' => 'bg-purple-100 text-purple-800', 'text' => 'Diagnosed'],
            '20' => ['class' => 'bg-indigo-100 text-indigo-800', 'text' => 'Repairing'],
            '30' => ['class' => 'bg-pink-100 text-pink-800', 'text' => 'Testing'],
            '40' => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Ready for Delivery'],
        ];

        return $statuses[$status] ?? $statuses['0'];
    }

    public function updateTimeRange($range)
    {
        $this->timeRange = $range;
        $this->dispatch('timeRangeUpdated');
    }

    public function updatePerformanceFilter($filter)
    {
        $this->performanceFilter = $filter;
        $this->dispatch('performanceFilterUpdated');
    }

    public function updateRevenueChartType($type)
    {
        $this->revenueChartType = $type;
        $this->dispatch('revenueChartTypeUpdated');
    }

    public function updateSelectedYear($year)
    {
        $this->selectedYear = $year;
        $this->dispatch('timeRangeUpdated');
    }
}
