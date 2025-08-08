<?php

namespace App\Livewire\Admin;

use App\Models\franchises;
use App\Models\Payment;
use App\Models\Receptioners;
use App\Models\ServiceRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class AdminDashboard extends Component
{
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $search = '';
    public $statusFilter = '';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function render()
    {
        $stats = [
            'totalFranchises' => franchises::count(),
            'activeStaff' => Staff::where('status', 'active')->count(),
            'receptionists' => Receptioners::count(),
            'monthlyRevenue' => Payment::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
            'growthRate' => $this->calculateGrowthRate(),
        ];

        $recentActivities = ServiceRequest::with(['technician', 'receptioner'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($request) {
                return [
                    'type' => 'Service Request',
                    'title' => 'New service request',
                    'description' => $request->product_name . ' from ' . $request->owner_name,
                    'time' => $request->created_at->diffForHumans(),
                    'icon' => 'fa-tasks',
                    'color' => 'blue'
                ];
            });

        $topFranchises = franchises::withCount(['serviceRequests as revenue' => function ($query) {
            $query->select(DB::raw('COALESCE(SUM(payments.total_amount), 0)'))
                ->join('payments', 'service_requests.id', '=', 'payments.service_request_id');
        }])
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();

        $franchises = franchises::query()
            ->when($this->search, function ($query) {
                $query->where('franchise_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('contact_no', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Revenue data for chart (last 12 months)
        $revenueData = Payment::selectRaw('
                YEAR(created_at) as year, 
                MONTH(created_at) as month, 
                SUM(total_amount) as total
            ')
            ->whereBetween('created_at', [now()->subMonths(11), now()])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $revenueChartData = [
            'labels' => $revenueData->map(function ($item) {
                return date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year));
            }),
            'data' => $revenueData->pluck('total')
        ];

        // Performance data for chart
        $performanceData = franchises::withSum(['payments as total_revenue'], 'total_amount')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        $performanceChartData = [
            'labels' => $performanceData->pluck('franchise_name'),
            'data' => $performanceData->pluck('total_revenue')
        ];

        return view('livewire.admin.admin-dashboard', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'topFranchises' => $topFranchises,
            'franchises' => $franchises,
            'revenueChartData' => $revenueChartData,
            'performanceChartData' => $performanceChartData
        ]);
    }

    protected function calculateGrowthRate()
    {
        $currentMonthRevenue = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $lastMonthRevenue = Payment::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');

        if ($lastMonthRevenue == 0) {
            return $currentMonthRevenue > 0 ? 100 : 0;
        }

        return round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2);
    }
}
