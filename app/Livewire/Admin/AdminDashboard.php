<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use App\Models\Payment;
use App\Models\Receptioners;
use App\Models\ServiceRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Admin Dashboard')]
#[Layout('components.layouts.admin-layout')]
class AdminDashboard extends Component
{
    use WithPagination;
    
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 7;
    public $search = '';
    public $statusFilter = '';

    public $totalFranchises;
    public $totalstaff;
    public $stats;
    public $serviceStatuses;
    public $franchiseRevenues;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        
        // Reset to first page when sorting
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function mount()
    {
        // Load all dashboard data (includes counts now)
        $this->loadDashboardData();
    }

    protected function loadDashboardData()
    {
        // Use a single cache for all dashboard data to minimize queries and avoid repeated/separate cache calls
        $dashboardData = Cache::remember('admin_dashboard_data', 300, function () {
            // Get franchise revenues in a single query - corrected table name to receptioners
            $franchiseRevenues = DB::table('franchises')
                ->leftJoin('receptioners', 'receptioners.franchise_id', '=', 'franchises.id')
                ->leftJoin('service_requests', 'service_requests.receptioners_id', '=', 'receptioners.id')
                ->leftJoin('payments', 'payments.service_request_id', '=', 'service_requests.id')
                ->select(
                    'franchises.id',
                    'franchises.franchise_name',
                    DB::raw('COALESCE(SUM(payments.total_amount), 0) as total_revenue'),
                    DB::raw('COALESCE(SUM(CASE WHEN payments.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN payments.total_amount ELSE 0 END), 0) as monthly_revenue'),
                    DB::raw('COALESCE(SUM(CASE WHEN payments.created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND payments.created_at < DATE_SUB(NOW(), INTERVAL 30 DAY) THEN payments.total_amount ELSE 0 END), 0) as previous_monthly_revenue')
                )
                ->groupBy('franchises.id', 'franchises.franchise_name')
                ->get()
                ->keyBy('id');

            // Precompute totals from the collection to avoid repeated sums later
            $totalRevenue = $franchiseRevenues->sum('total_revenue');
            $currentMonthRevenue = $franchiseRevenues->sum('monthly_revenue');
            $previousMonthRevenue = $franchiseRevenues->sum('previous_monthly_revenue');

            // Calculate global growth rate (using rolling 30 days for consistency with franchise data)
            $growthRate = $previousMonthRevenue == 0 
                ? ($currentMonthRevenue > 0 ? 100 : 0)
                : round((($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100, 2);

            // Get service request statuses
            $serviceStatuses = ServiceRequest::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->status => $item->count];
                });

            // Include all counts in this single cache callback to reduce separate queries/caches
            $totalFranchises = $franchiseRevenues->count(); // Derived from revenues query (avoids extra Franchise::count())
            $totalStaff = Staff::where('status', 'active')->count();

            return [
                'franchiseRevenues' => $franchiseRevenues,
                'totalFranchises' => $totalFranchises,
                'totalStaff' => $totalStaff,
                'stats' => [
                    'receptionists' => Receptioners::count(),
                    'monthlyRevenue' => $currentMonthRevenue,
                    'growthRate' => $growthRate,
                ],
                'serviceStatuses' => $serviceStatuses,
                'totalRevenue' => $totalRevenue, // Precomputed for use in growth calculations
            ];
        });

        // Extract data from the cached result
        $this->totalFranchises = $dashboardData['totalFranchises'];
        $this->totalstaff = $dashboardData['totalStaff'];
        $this->stats = $dashboardData['stats'];
        $this->serviceStatuses = $dashboardData['serviceStatuses'];
        $this->franchiseRevenues = $dashboardData['franchiseRevenues'];
        $this->totalRevenue = $dashboardData['totalRevenue']; // Store precomputed total for later use
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
        $franchises->getCollection()->transform(function ($franchise) {
            $revenueData = $this->franchiseRevenues->get($franchise->id, (object) [
                'total_revenue' => 0,
                'monthly_revenue' => 0,
                'previous_monthly_revenue' => 0,
            ]);

            $franchise->total_revenue = $revenueData->total_revenue;
            $franchise->monthly_revenue = $revenueData->monthly_revenue;
            
            // Calculate growth
            $franchise->growth = $this->calculateFranchiseGrowth($revenueData);
            
            return $franchise;
        });

        return view('livewire.admin.admin-dashboard', [
            'stats' => $this->stats,
            'franchises' => $franchises,
            'serviceStatuses' => $this->serviceStatuses,
        ]);
    }

    protected function calculateFranchiseGrowth($revenueData)
    {
        if (!$revenueData || $revenueData->monthly_revenue == 0) {
            return 0;
        }
        
        // Proper growth calculation: (current - previous) / previous * 100
        $previous = $revenueData->previous_monthly_revenue;
        $current = $revenueData->monthly_revenue;
        
        return $previous == 0 
            ? ($current > 0 ? 100 : 0)
            : round((($current - $previous) / $previous) * 100,2);
        }
}