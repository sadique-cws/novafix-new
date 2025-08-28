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

    public function getDashboardData()
    {
        $userId = Auth::guard('staff')->user()->id;
        $cacheKey = 'staff_dashboard_' . $userId;

        return Cache::remember($cacheKey, 10, function () use ($userId) {
            // Get all counts in a single query using conditional aggregates
            $counts = ServiceRequest::where('technician_id', $userId)
                ->selectRaw('
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as pending_count,
                    SUM(CASE WHEN status > 0 AND status < 100 THEN 1 ELSE 0 END) as in_progress_count,
                    SUM(CASE WHEN status = 100 AND DATE(updated_at) = CURDATE() THEN 1 ELSE 0 END) as completed_today_count
                ')
                ->first();

            // Get recent tasks
            $recentTasks = ServiceRequest::where('technician_id', $userId)
                ->with(['receptionist'])
                ->orderBy('created_at', 'desc')
                ->limit($this->recentTaskLimit)
                ->get();

            // Get upcoming deliveries
            $upcomingDeliveries = ServiceRequest::where('technician_id', $userId)
                ->where('status', '<', 100)
                ->orderBy('created_at', 'asc')
                ->limit($this->upcomingDeliveryLimit)
                ->get();

            return [
                'pendingTasksCount' => $counts->pending_count ?? 0,
                'inProgressTasksCount' => $counts->in_progress_count ?? 0,
                'completedTodayCount' => $counts->completed_today_count ?? 0,
                'recentTasks' => $recentTasks,
                'upcomingDeliveries' => $upcomingDeliveries
            ];
        });
    }

    public function render()
    {
        $data = $this->getDashboardData();

        return view('livewire.staff.dashboard', $data);
    }
}