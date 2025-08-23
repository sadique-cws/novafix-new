<?php

namespace App\Livewire\Staff;

use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;

#[Layout('components.layouts.staff-layout')]
#[Title('Dashboard')]

class Dashboard extends Component
{
    public $recentTaskLimit = 5;
    public $upcomingDeliveryLimit = 2;

    public function getPendingTasksCount()
    {
        try {
            return Cache::remember('pending_tasks_' . Auth::guard('staff')->user()->id, 60, function () {
                return ServiceRequest::where('technician_id', Auth::guard('staff')->user()->id)
                    ->where('status', 0)
                    ->count();
            });
        } catch (\Exception $e) {
            // Log the error and return a default value
            return 0;
        }
    }

    public function getInProgressTasksCount()
    {
        try {
            $userId = Auth::guard('staff')->user()->id;
            $cacheKey = 'in_progress_tasks_' . $userId;

            return Cache::remember($cacheKey, 60, function () use ($userId) {
                return ServiceRequest::where('technician_id', $userId)
                    ->where('status', '>', 0)
                    ->where('status', '<', 100)
                    ->count();
            });
        } catch (\Exception $e) {
            return 0;
        }
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
          
           
            ->where('status', '<', 100)
            
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
