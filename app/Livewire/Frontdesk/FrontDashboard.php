<?php

namespace App\Livewire\Frontdesk;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\ServiceRequest;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Receptioners;
use App\Models\ServiceCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;

#[Title('Front Desk Dashboard')]
#[Layout('components.layouts.frontdesk-layout')]
class FrontDashboard extends Component
{
    public $todayServicesCount = 0;
    public $inProgressCount = 0;
    public $completedCount = 0;
    public $recentServices = [];
    public $statusBreakdown = [];
    public $deviceBreakdown = [];
    public $recentPayments = [];
    public $topTechnicians = [];
    public $franchiseId;
    public $receptionerIds = [];
    public $todayRevenue = 0;

    public function mount()
    {
        // Get the authenticated receptionist's franchise ID
        $this->franchiseId = Auth::guard('frontdesk')->user()->franchise_id;

        // Get all receptionist IDs for this franchise
        $this->receptionerIds = Receptioners::where('franchise_id', $this->franchiseId)
            ->pluck('id')
            ->toArray();

        // Check if we have receptionists before proceeding
        if (!empty($this->receptionerIds)) {
            $this->loadData();
        }
    }

    public function loadData()
    {
        // Get all data in minimal queries
        $this->loadServiceCounts();
        $this->loadRecentServices();
        $this->loadStatusAndDeviceBreakdown();
        $this->loadRecentPayments();
        $this->loadTopTechnicians();
        $this->loadTodayRevenue();
    }

    protected function loadServiceCounts()
    {
        // Get today's, in-progress, and completed counts in separate queries
        // to avoid the count() issue with the raw query

        $this->todayServicesCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $this->inProgressCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status',  25)
            ->count();

        $this->completedCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', 100)
            ->count();
    }

    protected function loadTodayRevenue()
    {
        // Today's revenue for this franchise
        $this->todayRevenue = Payment::whereHas('serviceRequest', function ($query) {
            $query->whereIn('receptioners_id', $this->receptionerIds)
                ->whereDate('created_at', Carbon::today());
        })
            ->sum('total_amount');
    }

    protected function loadRecentServices()
    {
        // Recent services (last 5) for this franchise
        $this->recentServices = ServiceRequest::with(['serviceCategory', 'technician'])
            ->whereIn('receptioners_id', $this->receptionerIds)
            ->latest()
            ->take(5)
            ->get();
    }

    protected function loadStatusAndDeviceBreakdown()
    {
        // Initialize with default values
        $this->statusBreakdown = [
            'Diagnosis' => 0,
            'Repair' => 0,
            'Quality Check' => 0,
            'Ready for Pickup' => 0
        ];

        $this->deviceBreakdown = [
            'Laptops' => 0,
            'Smartphones' => 0,
            'Tablets' => 0,
            'Others' => 0
        ];

        // Only run queries if we have receptionists
        if (empty($this->receptionerIds)) {
            return;
        }

        // Get status breakdown using separate queries to avoid complex raw queries
        $this->statusBreakdown['Diagnosis'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', '<', 0.25)
            ->count();

        $this->statusBreakdown['Repair'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', '>=', 0.25)
            ->where('status', '<', 0.5)
            ->count();

        $this->statusBreakdown['Quality Check'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', '>=', 0.5)
            ->where('status', '<', 1)
            ->count();

        $this->statusBreakdown['Ready for Pickup'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', 1)
            ->count();

        // Get device breakdown using separate queries
        $this->deviceBreakdown['Laptops'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where(function ($query) {
                $query->where('product_name', 'like', '%laptop%')
                    ->orWhere('product_name', 'like', '%LAPTOP%');
            })
            ->count();

        $this->deviceBreakdown['Smartphones'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where(function ($query) {
                $query->where('product_name', 'like', '%phone%')
                    ->orWhere('product_name', 'like', '%PHONE%')
                    ->orWhere('product_name', 'like', '%mobile%')
                    ->orWhere('product_name', 'like', '%MOBILE%');
            })
            ->count();

        $this->deviceBreakdown['Tablets'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where(function ($query) {
                $query->where('product_name', 'like', '%tablet%')
                    ->orWhere('product_name', 'like', '%TABLET%')
                    ->orWhere('product_name', 'like', '%ipad%')
                    ->orWhere('product_name', 'like', '%IPAD%');
            })
            ->count();

        $this->deviceBreakdown['Others'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->count() - ($this->deviceBreakdown['Laptops'] + $this->deviceBreakdown['Smartphones'] + $this->deviceBreakdown['Tablets']);
    }

    protected function loadRecentPayments()
    {
        // Recent payments for this franchise
        $this->recentPayments = Payment::with(['serviceRequest', 'staff', 'receivedBy'])
            ->whereHas('serviceRequest', function ($query) {
                $query->whereIn('receptioners_id', $this->receptionerIds);
            })
            ->latest()
            ->take(5)
            ->get();
    }

    protected function loadTopTechnicians()
    {
        // Top technicians for this franchise
        $this->topTechnicians = Staff::where('franchise_id', $this->franchiseId)
           
            ->withCount(['serviceRequests as completed_services' => function ($query) {
                $query->where('status', 1)
                    ->whereIn('receptioners_id', $this->receptionerIds);
            }])
            ->with('serviceCategory')
            ->orderByDesc('completed_services')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.frontdesk.front-dashboard', [
            'todayServicesCount' => $this->todayServicesCount,
            'inProgressCount' => $this->inProgressCount,
            'completedCount' => $this->completedCount,
            'recentServices' => $this->recentServices,
            'statusBreakdown' => $this->statusBreakdown,
            'deviceBreakdown' => $this->deviceBreakdown,
            'recentPayments' => $this->recentPayments,
            'topTechnicians' => $this->topTechnicians,
            'todayRevenue' => $this->todayRevenue,
        ]);
    }
}
