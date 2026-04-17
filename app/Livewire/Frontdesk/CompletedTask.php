<?php

namespace App\Livewire\Frontdesk;

use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequest;
use App\Models\Staff;
use App\Models\Technician;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
#[Title('Completed Tasks')]
#[Layout('components.layouts.frontdesk-layout')]

class CompletedTask extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage'
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ServiceRequest::query()
            ->where('receptioners_id', Auth::guard('frontdesk')->user()->id)
            ->where('status', operator: 2); // Only completed tasks

        // Calculate stats
        $totalCompleted = (clone $query)->count();
        $thisWeekCount = (clone $query)->where('updated_at', '>=', Carbon::now()->subWeek())->count();

        // Get top technician
        $topTechnician = Staff::select('staff.name')
            ->join('service_requests', 'staff.id', '=', 'service_requests.technician_id')
            ->where('service_requests.receptioners_id', Auth::guard('frontdesk')->user()->id)
            ->where('service_requests.status', 2)
            ->selectRaw('count(*) as count')
            ->groupBy('staff.id', 'staff.name')
            ->orderByDesc('count')
            ->first();

        // Calculate average resolution time in days
        $resolutionRows = (clone $query)->get(['created_at', 'updated_at']);
        $averageResolutionDays = $resolutionRows->count()
            ? round(
                $resolutionRows
                    ->avg(fn ($row) => $row->updated_at && $row->created_at
                        ? Carbon::parse($row->created_at)->diffInDays(Carbon::parse($row->updated_at))
                        : 0),
                1
            )
            : 0;

        // Apply search and sorting
        $requests = $query
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('service_code', 'like', '%' . $this->search . '%')
                        ->orWhere('owner_name', 'like', '%' . $this->search . '%')
                        ->orWhere('product_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.frontdesk.completed-task', [
            'requests' => $requests,
            'totalCompleted' => $totalCompleted,
            'thisWeekCount' => $thisWeekCount,
            'topTechnician' => $topTechnician,
            'averageResolutionDays' => $averageResolutionDays,
        ]);
    }
}
