<?php

namespace App\Livewire\Admin;

use App\Models\franchises;
use App\Models\Payment;
use App\Models\Receptioners;
use App\Models\ServiceRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\DB; // Add this line

use Illuminate\View\View;
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
            'monthlyRevenue' => Payment::sum('total_amount'), // Simplified for small data
            'growthRate' => $this->calculateGrowthRate(),
        ];
        // Recent Activity - show all available
        $recentActivities = ServiceRequest::with(['technician', 'receptionist'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($request) {
                return [
                    'title' => 'Service Request',
                    'description' => ($request->product_name ?? 'No product') . ' from ' . ($request->owner_name ?? 'Unknown'),
                    'time' => $request->created_at->diffForHumans(),
                    'icon' => 'fa-tasks',
                    'color' => 'blue'
                ];
            });


        // Top Franchises - handle case with only 2 franchises
        $topFranchises = franchises::withSum(['payments'], 'total_amount')
            ->orderBy('payments_sum_total_amount', 'desc')
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
            DATE_FORMAT(created_at, "%b %Y") as month_year,
            SUM(total_amount) as total
        ')
            ->groupBy('month_year')
            ->orderByRaw('MIN(created_at)')
            ->get();
        if ($revenueData->isEmpty()) {
            $revenueData = collect([
                (object)['month_year' => now()->format('M Y'), 'total' => 0]
            ]);
        }

        $revenueChartData = [
            'labels' => $revenueData->pluck('month_year'),
            'data' => $revenueData->pluck('total')
        ];
        // Replace the performance data collection with this:
        // Replace the performance data collection with this:
        $performanceData = DB::table('franchises')
            ->select(
                'franchises.id',
                'franchises.franchise_name',
                DB::raw('SUM(payments.total_amount) as total_revenue')
            )
            ->join('receptioners', 'receptioners.franchise_id', '=', 'franchises.id')
            ->join('service_requests', 'service_requests.receptioners_id', '=', 'receptioners.id')
            ->join('payments', 'payments.service_request_id', '=', 'service_requests.id')
            ->groupBy('franchises.id', 'franchises.franchise_name')
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

        'revenueChartData' => [
            'labels' => $revenueData->pluck('month_year'),
            'data' => $revenueData->pluck('total')
        ],
        'performanceChartData' => [
            'labels' => $topFranchises->pluck('franchise_name'),
            'data' => $topFranchises->pluck('payments_sum_total_amount')
        ]
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
