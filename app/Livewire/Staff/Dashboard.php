<?php

namespace App\Livewire\Staff;

use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.staff-layout')]
class Dashboard extends Component
{
    public $recentTaskLimit = 5;
    public $upcomingDeliveryLimit = 2;

    public function getPendingTasksCount()
    {
        return ServiceRequest::where('technician_id', Auth::guard('staff')->user()->id)
            ->where('status', 0)
            ->count();
    }

    public function getInProgressTasksCount()
    {
        return ServiceRequest::where('technician_id', Auth::guard('staff')->user()->id)
            ->where('status', '>', 0)
            ->where('status', '<', 100)
            ->count();
    }

    public function getCompletedTodayCount()
    {
        return ServiceRequest::where('technician_id', Auth::guard('staff')->user()->id)
            ->where('status', 100)
            ->whereDate('updated_at', today())
            ->count();
    }

    public function getRecentTasks()
    {
        return ServiceRequest::where('technician_id', Auth::guard('staff')->user()->id)
            ->with(['receptionist'])
            ->orderBy('created_at', 'desc')
            ->limit($this->recentTaskLimit)
            ->get();
    }

    public function getUpcomingDeliveries()
    {
        return ServiceRequest::where('technician_id', Auth::guard('staff')->user()->id)
            ->whereNotNull('date_of_delivery')
            ->where('date_of_delivery', '>=', now())
            ->where('status', '<', 100)
            ->orderBy('date_of_delivery')
            ->limit($this->upcomingDeliveryLimit)
            ->get();
    }

    public function render()
    {
        return view('livewire.staff.dashboard', [
            'pendingTasksCount' => $this->getPendingTasksCount(),
            'inProgressTasksCount' => $this->getInProgressTasksCount(),
            'completedTodayCount' => $this->getCompletedTodayCount(),
            'recentTasks' => $this->getRecentTasks(),
            'upcomingDeliveries' => $this->getUpcomingDeliveries()
        ]);
    }
}
