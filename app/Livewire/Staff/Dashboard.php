<?php

namespace App\Livewire\Staff;

use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Layout('components.layouts.staff-layout')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public $recentTaskLimit = 5;
    public $upcomingDeliveryLimit = 2;

    public function getDashboardData()
    {
        $userId = Auth::guard('staff')->user()->id;
        
        // Get all service requests for the technician in a single query
        $serviceRequests = ServiceRequest::where('technician_id', $userId)
            ->with(['receptionist'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Calculate counts from the collection
        $pendingTasksCount = $serviceRequests->where('status', 0)->count();
        $inProgressTasksCount = $serviceRequests->where('status', 1)->count();
        $completedTodayCount = $serviceRequests->where('status', 2)
            ->filter(function ($item) {
                return $item->updated_at->isToday();
            })->count();
            
        // Get recent tasks (already ordered by created_at desc)
        $recentTasks = $serviceRequests->take($this->recentTaskLimit);
        
        // Get upcoming deliveries (incomplete tasks, ordered by creation date)
        $upcomingDeliveries = $serviceRequests->where('status', '<', 2)
            ->sortBy('created_at')
            ->take($this->upcomingDeliveryLimit);

        return [
            'pendingTasksCount' => $pendingTasksCount,
            'inProgressTasksCount' => $inProgressTasksCount,
            'completedTodayCount' => $completedTodayCount,
            'recentTasks' => $recentTasks,
            'upcomingDeliveries' => $upcomingDeliveries
        ];
    }

    public function render()
    {
        $data = $this->getDashboardData();

        return view('livewire.staff.dashboard', $data);
    }
}