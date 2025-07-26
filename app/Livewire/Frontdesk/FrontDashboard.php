<?php

namespace App\Livewire\Frontdesk;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\ServiceRequest;
use App\Models\Payment;
use App\Models\Staff;
use Carbon\Carbon;

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

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Today's services
        $this->todayServicesCount = ServiceRequest::whereDate('created_at', Carbon::today())->count();

        // In progress services (status between 0.1 and 0.99)
        $this->inProgressCount = ServiceRequest::where('status', '>', 0)
            ->where('status', '<', 1)
            ->count();

        // Completed services (status = 1)
        $this->completedCount = ServiceRequest::where('status', 1)->count();

        // Recent services (last 5)
        $this->recentServices = ServiceRequest::with(['serviceCategory', 'technician'])
            ->latest()
            ->take(5)
            ->get();

        // Status breakdown
        $this->statusBreakdown = [
            'Diagnosis' => ServiceRequest::where('status', '<', 0.25)->count(),
            'Repair' => ServiceRequest::where('status', '>=', 0.25)
                ->where('status', '<', 0.75)
                ->count(),
            'Quality Check' => ServiceRequest::where('status', '>=', 0.75)
                ->where('status', '<', 1)
                ->count(),
            'Ready for Pickup' => ServiceRequest::where('status', 1)->count()
        ];

        // Device breakdown (example - you'd need to adjust based on your product_name structure)
        $this->deviceBreakdown = [
            'Laptops' => ServiceRequest::where('product_name', 'like', '%laptop%')->count(),
            'Smartphones' => ServiceRequest::where('product_name', 'like', '%phone%')->count(),
            'Tablets' => ServiceRequest::where('product_name', 'like', '%tablet%')->count(),
            'Others' => ServiceRequest::whereNotIn('product_name', ['%laptop%', '%phone%', '%tablet%'])->count()
        ];

        // Recent payments
        $this->recentPayments = Payment::with(['serviceRequest', 'staff', 'receivedBy'])
            ->latest()
            ->take(5)
            ->get();

        // Top technicians
        $this->topTechnicians = Staff::withCount(['serviceRequests as completed_services' => function ($query) {
            $query->where('status', 1);
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
