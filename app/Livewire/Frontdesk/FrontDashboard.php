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
    public $todayServicesCount ;
    public $inProgressCount = 0;
    public $completedCount = 0;
    public $recentServices = [];
    public $statusBreakdown = [];
    public $deviceBreakdown = [];
    public $recentPayments = [];
    public $topTechnicians = [];
    public $franchiseId;
    public $receptionerIds = [];
    public $todayRevenue ;

    public function mount()
    {
        // Get the authenticated receptionist
        $user = Auth::user();

        if (!$user) {
            // Try alternative authentication method
            $user = auth()->guard('frontdesk')->user()->id;
        }

        if ($user) {
            $this->franchiseId = $user->franchise_id;

            // Get all receptionist IDs for this franchise
            $this->receptionerIds = Receptioners::where('franchise_id', $this->franchiseId)
                ->pluck('id')
                ->toArray();

            $this->loadData();
        }
    }

    public function loadData()
    {
        $this->loadServiceCounts();
        $this->loadRecentServices();
        $this->loadStatusAndDeviceBreakdown();
        $this->loadRecentPayments();
        $this->loadTopTechnicians();
        $this->loadTodayRevenue();
    }

    protected function loadServiceCounts()
    {
        $today = Carbon::today()->toDateString();

        // Today's services count
        $this->todayServicesCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)->where('status_request', 1)
            ->whereDate('created_at', $today)
            ->count();

        // In-progress services count (status 25)
        $this->inProgressCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)->where('status_request', 1)
            ->where('status', 25)
            ->count();

        // Completed services count (status 100)
        $this->completedCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)->where('status_request', 1)
            ->where('status', 100)
            ->count();
    }

    protected function loadTodayRevenue()
    {
        $today = Carbon::today()->toDateString();

        // Today's revenue for this franchise
        $this->todayRevenue = Payment::whereHas('serviceRequest', function ($query) use ($today) {
            $query->whereIn('receptioners_id', $this->receptionerIds)
                ->whereDate('created_at', $today);
        })
            ->sum('total_amount');
    }

    protected function loadRecentServices()
    {
        // Recent services (last 5) for this franchise
        $this->recentServices = ServiceRequest::with(['serviceCategory', 'technician'])
            ->whereIn('receptioners_id', $this->receptionerIds)
            ->orderBy('created_at', 'desc')
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

        // Get status breakdown
        $this->statusBreakdown['Diagnosis'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', '<', 25)
            ->count();

        $this->statusBreakdown['Repair'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', '>=', 25)
            ->where('status', '<', 50)
            ->count();

        $this->statusBreakdown['Quality Check'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', '>=', 50)
            ->where('status', '<', 100)
            ->count();

        $this->statusBreakdown['Ready for Pickup'] = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', 100)
            ->count();

        // Get device breakdown
        $laptops = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where(function ($query) {
                $query->where('product_name', 'like', '%laptop%')
                    ->orWhere('product_name', 'like', '%LAPTOP%')
                    ->orWhere('product_name', 'like', '%notebook%')
                    ->orWhere('product_name', 'like', '%NOTEBOOK%');
            })
            ->count();

        $smartphones = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where(function ($query) {
                $query->where('product_name', 'like', '%phone%')
                    ->orWhere('product_name', 'like', '%PHONE%')
                    ->orWhere('product_name', 'like', '%mobile%')
                    ->orWhere('product_name', 'like', '%MOBILE%')
                    ->orWhere('product_name', 'like', '%smartphone%')
                    ->orWhere('product_name', 'like', '%SMARTPHONE%');
            })
            ->count();

        $tablets = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where(function ($query) {
                $query->where('product_name', 'like', '%tablet%')
                    ->orWhere('product_name', 'like', '%TABLET%')
                    ->orWhere('product_name', 'like', '%ipad%')
                    ->orWhere('product_name', 'like', '%IPAD%');
            })
            ->count();

        $totalDevices = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)->count();

        $this->deviceBreakdown['Laptops'] = $laptops;
        $this->deviceBreakdown['Smartphones'] = $smartphones;
        $this->deviceBreakdown['Tablets'] = $tablets;
        $this->deviceBreakdown['Others'] = $totalDevices - ($laptops + $smartphones + $tablets);
    }

    protected function loadRecentPayments()
    {
        // Recent payments for this franchise
        $this->recentPayments = Payment::with(['serviceRequest', 'staff', 'receivedBy'])
            ->whereHas('serviceRequest', function ($query) {
                $query->whereIn('receptioners_id', $this->receptionerIds);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    protected function loadTopTechnicians()
    {
        // Top technicians for this franchise
        $this->topTechnicians = Staff::where('franchise_id', $this->franchiseId)
            ->withCount(['serviceRequests as completed_services' => function ($query) {
                $query->where('status', 100)
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
