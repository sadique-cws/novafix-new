<?php

namespace App\Livewire\Franchise;

use App\Models\Franchises;
use App\Models\Payment;
use App\Models\Receptioners;
use App\Models\ServiceRequest;
use App\Models\ServiceCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.franchise-layout')]
class Dashboard extends Component
{
    public $franchiseId;
    public $timeRange = 'monthly';
    public $performanceFilter = 'Top Performing';

    public function mount()
    {
        $this->franchiseId = Auth::guard('franchise')->user()->id;
    }

    public function render()
    {
        $stats = $this->getStats();
        $revenueData = $this->getRevenueData();
        $performanceData = $this->getPerformanceData();
        $recentOrders = $this->getRecentOrders();

        return view('livewire.franchise.dashboard', [
            'stats' => $stats,
            'revenueData' => $revenueData,
            'performanceData' => $performanceData,
            'recentOrders' => $recentOrders,
        ]);
    }

    
    protected function getStats()
    {
        $franchiseId = Auth::guard('franchise')->id();

        // Get all receptioner IDs for this franchise
        $receptionerIds = Receptioners::where('franchise_id', $franchiseId)
            ->pluck('id');

        // Total customers
        $totalCustomers = ServiceRequest::whereIn('receptioners_id', $receptionerIds)
            ->distinct('contact')
            ->count('contact');

        // Services completed
        $servicesCompleted = ServiceRequest::whereIn('receptioners_id', $receptionerIds)
            ->where('status', 'completed')
            ->count();

        // Total revenue
        $totalRevenue = Payment::whereHas('serviceRequest', function ($query) use ($receptionerIds) {
            $query->whereIn('receptioners_id', $receptionerIds);
        })
            ->where('status', 'completed')
            ->sum('total_amount');

        // Total receptionists
        $totalReceptionists = Receptioners::where('franchise_id', $franchiseId)
            ->count();

        return [
            'totalReceptionists' => $totalReceptionists,
            'totalCustomers' => $totalCustomers,
            'servicesCompleted' => $servicesCompleted,
            'totalRevenue' => $totalRevenue,
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
                ->whereYear('payments.created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $values = array_fill(0, 12, 0);

            foreach ($data as $item) {
                $values[$item->month - 1] = $item->revenue;
            }
        } else {
            $data = Payment::selectRaw('
                    YEAR(payments.created_at) as year,
                    SUM(payments.total_amount) as revenue
                ')
                ->join('service_requests', 'payments.service_request_id', '=', 'service_requests.id')
                ->whereIn('service_requests.receptioners_id', $receptionerIds)
                ->where('payments.status', 'completed')
                ->groupBy('year')
                ->orderBy('year')
                ->get();

            $currentYear = date('Y');
            $labels = [];
            $values = [];

            for ($i = 4; $i >= 0; $i--) {
                $year = $currentYear - $i;
                $labels[] = $year;
                $values[] = $data->where('year', $year)->first()->revenue ?? 0;
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

        $services = ServiceRequest::selectRaw('
                service_categories.name as service_name,
                COUNT(service_requests.id) as request_count,
                SUM(payments.total_amount) as total_revenue
            ')
            ->join('service_categories', 'service_requests.service_categories_id', '=', 'service_categories.id')
            ->leftJoin('payments', function ($join) {
                $join->on('service_requests.id', '=', 'payments.service_request_id')
                    ->where('payments.status', 'completed');
            })
            ->whereIn('service_requests.receptioners_id', $receptionerIds)
            ->groupBy('service_categories.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

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
                ];
            });
    }

    protected function getFranchiseReceptionerIds()
    {
        return Receptioners::where('franchise_id', $this->franchiseId)
            ->pluck('id')
            ->toArray();
    }

    protected function getStatusInfo($status)
    {
        switch ($status) {
            case 'completed':
                return ['class' => 'bg-green-100 text-green-800', 'text' => 'Completed'];
            case 'in_progress':
                return ['class' => 'bg-blue-100 text-blue-800', 'text' => 'In Progress'];
            case 'cancelled':
                return ['class' => 'bg-red-100 text-red-800', 'text' => 'Cancelled'];
            default:
                return ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pending'];
        }
    }

    public function updateTimeRange($range)
    {
        $this->timeRange = $range;
    }

    public function updatePerformanceFilter($filter)
    {
        $this->performanceFilter = $filter;
    }
}
