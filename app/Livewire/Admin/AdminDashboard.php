<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use App\Models\Payment;
use App\Models\Receptioners;
use App\Models\ServiceRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Admin Dashboard')]
#[Layout('components.layouts.admin-layout')]
class AdminDashboard extends Component
{
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $search = '';
    public $statusFilter = '';

    public $totalFranchises;
    public $totalstaff;
    public $stats;
    public $topFranchises;
    public $serviceStatuses;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function mount()
    {
        // Load basic counts with caching
        $this->totalFranchises = Cache::remember('total_Franchises', 1800, function () {
            return Franchise::count();
        });

        $this->totalstaff = Cache::remember('total_staff', now()->addMinutes(30), function () {
            return Staff::where('status', 'active')->count();
        });

        // Load all dashboard data in a single optimized query
        $this->loadDashboardData();
    }

    protected function loadDashboardData()
    {
        // Use a single cache for all dashboard data to minimize queries
        $dashboardData = Cache::remember('admin_dashboard_data', 300, function () {
            // Get franchise revenues in a single query
            $franchiseRevenues = DB::table('franchises')
                ->leftJoin('receptioners', 'receptioners.franchise_id', '=', 'franchises.id')
                ->leftJoin('service_requests', 'service_requests.receptioners_id', '=', 'receptioners.id')
                ->leftJoin('payments', 'payments.service_request_id', '=', 'service_requests.id')
                ->select(
                    'franchises.id',
                    'franchises.franchise_name',
                    DB::raw('COALESCE(SUM(payments.total_amount), 0) as total_revenue'),
                    DB::raw('COALESCE(SUM(CASE WHEN payments.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN payments.total_amount ELSE 0 END), 0) as monthly_revenue')
                )
                ->groupBy('franchises.id', 'franchises.franchise_name')
                ->get()
                ->keyBy('id');

            // Calculate growth rates in the same query
            $currentMonthRevenue = Payment::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount');

            $lastMonthRevenue = Payment::whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->sum('total_amount');

            $growthRate = $lastMonthRevenue == 0 
                ? ($currentMonthRevenue > 0 ? 100 : 0)
                : round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2);

            // Get service request statuses
            $serviceStatuses = ServiceRequest::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->status => $item->count];
                });

            return [
                'franchiseRevenues' => $franchiseRevenues,
                'stats' => [
                    'receptionists' => Receptioners::count(),
                    'monthlyRevenue' => $franchiseRevenues->sum('monthly_revenue'),
                    'growthRate' => $growthRate,
                ],
                'topFranchises' => $franchiseRevenues->sortByDesc('total_revenue')->take(5),
                'serviceStatuses' => $serviceStatuses,
            ];
        });

        // Extract data from the cached result
        $this->stats = $dashboardData['stats'];
        $this->topFranchises = $dashboardData['topFranchises'];
        $this->serviceStatuses = $dashboardData['serviceStatuses'];
    }

    public function render()
    {
        // Get franchises with pagination and search/filter
        $franchises = Franchise::query()
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

        // Add revenue data to each franchise from cached data
        $dashboardData = Cache::get('admin_dashboard_data');
        $franchiseRevenues = $dashboardData['franchiseRevenues'] ?? collect();
        
        $franchises->getCollection()->transform(function ($franchise) use ($franchiseRevenues) {
            $revenueData = $franchiseRevenues->get($franchise->id, (object) [
                'total_revenue' => 0,
                'monthly_revenue' => 0
            ]);

            $franchise->total_revenue = $revenueData->total_revenue;
            $franchise->monthly_revenue = $revenueData->monthly_revenue;
            
            // Calculate growth inline to avoid additional queries
            $franchise->growth = $this->calculateFranchiseGrowth($franchise->id, $franchiseRevenues);
            
            return $franchise;
        });

        return view('livewire.admin.admin-dashboard', [
            'stats' => $this->stats,
            'topFranchises' => $this->topFranchises,
            'franchises' => $franchises,
            'serviceStatuses' => $this->serviceStatuses,
        ]);
    }

    protected function calculateFranchiseGrowth($franchiseId, $franchiseRevenues)
    {
        // This is a simplified calculation based on available data
        // For a more accurate growth calculation, we'd need historical data
        $revenueData = $franchiseRevenues->get($franchiseId);
        
        if (!$revenueData || $revenueData->monthly_revenue == 0) {
            return 0;
        }
        
        // Simple growth calculation based on proportion of total revenue
        // This is a placeholder - you might want to implement a more accurate growth metric
        $totalRevenue = $franchiseRevenues->sum('total_revenue');
        if ($totalRevenue == 0) return 0;
        
        return round(($revenueData->monthly_revenue / $totalRevenue) * 100, 2);
    }
}