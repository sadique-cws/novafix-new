<?php

namespace App\Livewire\Frontdesk;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\ServiceRequest;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Receptioners;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;

#[Title('Front Desk Dashboard')]
#[Layout('components.layouts.frontdesk-layout')]
class FrontDashboard extends Component
{
    public $todayServicesCount;
    public $inProgressCount;
    public $completedCount;
    public $recentServices;
    public $statusBreakdown;
    public $deviceBreakdown;
    public $recentPayments;
    public $topTechnicians;
    public $franchiseId;
    public $receptionerIds;

    public function mount()
    {
        // Get the authenticated receptionist's franchise ID
        $this->franchiseId = Auth::guard('frontdesk')->user()->franchise_id;

        // Get all receptionist IDs for this franchise
        $this->receptionerIds = Receptioners::where('franchise_id', $this->franchiseId)
            ->pluck('id')
            ->toArray();

        $this->loadData();
    }

    public function loadData()
    {
        // Get all data in minimal queries
        $this->loadServiceCounts();
        $this->loadRecentServices();
        $this->loadStatusAndDeviceBreakdown();
        $this->loadRecentPayments();
        $this->loadTopTechnicians();
    }

    protected function loadServiceCounts()
    {
        // Get today's, in-progress, and completed counts in a single query
        $counts = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today_count,
                SUM(CASE WHEN status > 0 AND status < 1 THEN 1 ELSE 0 END) as in_progress_count,
                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as completed_count
            ')
            ->first();

        $this->todayServicesCount = $counts->today_count;
        $this->inProgressCount = $counts->in_progress_count;
        $this->completedCount = $counts->completed_count;
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
        // Get status and device breakdown in a single query
        $breakdown = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->selectRaw('
                SUM(CASE WHEN status < 0.25 THEN 1 ELSE 0 END) as diagnosis,
                SUM(CASE WHEN status >= 0.25 AND status < 0.75 THEN 1 ELSE 0 END) as repair,
                SUM(CASE WHEN status >= 0.75 AND status < 1 THEN 1 ELSE 0 END) as quality_check,
                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as ready_for_pickup,
                SUM(CASE WHEN product_name LIKE "%laptop%" THEN 1 ELSE 0 END) as laptops,
                SUM(CASE WHEN product_name LIKE "%phone%" THEN 1 ELSE 0 END) as smartphones,
                SUM(CASE WHEN product_name LIKE "%tablet%" THEN 1 ELSE 0 END) as tablets,
                SUM(CASE WHEN product_name NOT LIKE "%laptop%" AND product_name NOT LIKE "%phone%" AND product_name NOT LIKE "%tablet%" THEN 1 ELSE 0 END) as others
            ')
            ->first();

        $this->statusBreakdown = [
            'Diagnosis' => $breakdown->diagnosis,
            'Repair' => $breakdown->repair,
            'Quality Check' => $breakdown->quality_check,
            'Ready for Pickup' => $breakdown->ready_for_pickup
        ];

        $this->deviceBreakdown = [
            'Laptops' => $breakdown->laptops,
            'Smartphones' => $breakdown->smartphones,
            'Tablets' => $breakdown->tablets,
            'Others' => $breakdown->others
        ];
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
            ->orderByDesc('completed_services')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.frontdesk.front-dashboard');
    }
}