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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function mount(){
          $this->totalFranchises=Cache::remember('total_Franchises',1800,function(){
              return Franchise::count();
            });

            $this->totalstaff=cache::remember('total_staff',now()->addMinutes(30),function(){
                return Staff::where('status', 'active')->count();
            });

            
    }

    public function render()
    {
        // Calculate franchise revenues
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

        $stats = [
          
           
            //  'totalFranchises' => Franchise::count(),
            // 'activeStaff' => Staff::where('status', 'active')->count(),
            'receptionists' => Receptioners::count(),
            'monthlyRevenue' => $franchiseRevenues->sum('monthly_revenue'),
            'growthRate' => $this->calculateGrowthRate(),
        ];

        

        // Top Franchises by revenue
        $topFranchises = $franchiseRevenues->sortByDesc('total_revenue')->take(5);

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

        // Add revenue data to each franchise
        $franchises->getCollection()->transform(function ($franchise) use ($franchiseRevenues) {
            $revenueData = $franchiseRevenues->get($franchise->id, (object) [
                'total_revenue' => 0,
                'monthly_revenue' => 0
            ]);

            $franchise->total_revenue = $revenueData->total_revenue;
            $franchise->monthly_revenue = $revenueData->monthly_revenue;
            $franchise->growth = $this->calculateFranchiseGrowth($franchise->id);

            return $franchise;
        });

        // Service request status breakdown
        $serviceStatuses = ServiceRequest::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });

        return view('livewire.admin.admin-dashboard', [
            'stats' => $stats,
            'topFranchises' => $topFranchises,
            'franchises' => $franchises,
            'serviceStatuses' => $serviceStatuses,
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

    protected function calculateFranchiseGrowth($franchiseId)
    {
        $currentMonthRevenue = DB::table('payments')
            ->join('service_requests', 'payments.service_request_id', '=', 'service_requests.id')
            ->join('receptioners', 'service_requests.receptioners_id', '=', 'receptioners.id')
            ->where('receptioners.franchise_id', $franchiseId)
            ->whereMonth('payments.created_at', now()->month)
            ->whereYear('payments.created_at', now()->year)
            ->sum('payments.total_amount');

        $lastMonthRevenue = DB::table('payments')
            ->join('service_requests', 'payments.service_request_id', '=', 'service_requests.id')
            ->join('receptioners', 'service_requests.receptioners_id', '=', 'receptioners.id')
            ->where('receptioners.franchise_id', $franchiseId)
            ->whereMonth('payments.created_at', now()->subMonth()->month)
            ->whereYear('payments.created_at', now()->subMonth()->year)
            ->sum('payments.total_amount');

        if ($lastMonthRevenue == 0) {
            return $currentMonthRevenue > 0 ? 100 : 0;
        }

        return round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2);
    }

    protected function getTotalCustomers()
    {
        return DB::table('service_requests')
            ->distinct('email')
            ->count('email');
    }
}
