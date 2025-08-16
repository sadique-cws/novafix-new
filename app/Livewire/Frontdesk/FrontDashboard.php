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
        // Today's services for this franchise's receptionists
        $this->todayServicesCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // In progress services for this franchise (status between 0.1 and 0.99)
        $this->inProgressCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', '>', 0)
            ->where('status', '<', 1)
            ->count();

        // Completed services for this franchise (status = 1)
        $this->completedCount = ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
            ->where('status', 1)
            ->count();

        // Recent services (last 5) for this franchise
        $this->recentServices = ServiceRequest::with(['serviceCategory', 'technician'])
            ->whereIn('receptioners_id', $this->receptionerIds)
            ->latest()
            ->take(5)
            ->get();

        // Status breakdown for this franchise
        $this->statusBreakdown = [
            'Diagnosis' => ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
                ->where('status', '<', 0.25)
                ->count(),
            'Repair' => ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
                ->where('status', '>=', 0.25)
                ->where('status', '<', 0.75)
                ->count(),
            'Quality Check' => ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
                ->where('status', '>=', 0.75)
                ->where('status', '<', 1)
                ->count(),
            'Ready for Pickup' => ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
                ->where('status', 1)
                ->count()
        ];

        // Device breakdown for this franchise
        $this->deviceBreakdown = [
            'Laptops' => ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
                ->where('product_name', 'like', '%laptop%')
                ->count(),
            'Smartphones' => ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
                ->where('product_name', 'like', '%phone%')
                ->count(),
            'Tablets' => ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
                ->where('product_name', 'like', '%tablet%')
                ->count(),
            'Others' => ServiceRequest::whereIn('receptioners_id', $this->receptionerIds)
                ->whereNotIn('product_name', ['%laptop%', '%phone%', '%tablet%'])
                ->count()
        ];

        // Recent payments for this franchise
        $this->recentPayments = Payment::with(['serviceRequest', 'staff', 'receivedBy'])
            ->whereHas('serviceRequest', function ($query) {
                $query->whereIn('receptioners_id', $this->receptionerIds);
            })
            ->latest()
            ->take(5)
            ->get();

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
