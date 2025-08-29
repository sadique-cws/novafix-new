<?php

namespace App\Livewire\Frontdesk;

use App\Models\ServiceRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.frontdesk-layout')]
class ManageUserRequest extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $technicians = [];
    public $stats = [];

    protected $franchise_id;
    protected $receptionist_id;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage'
    ];

    public function mount()
    {
        $user = Auth::guard('frontdesk')->user();
        $this->franchise_id = $user->franchise_id;
        $this->receptionist_id = $user->id;
        $this->loadInitialData();
    }

    public function loadInitialData()
    {
        // Load technicians once
        $this->technicians = Staff::where('franchise_id', $this->franchise_id)
            ->get();

        // Calculate all stats in a single query
        $statsData = ServiceRequest::where('franchise_id', $this->franchise_id)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as pending')
            ->selectRaw('SUM(CASE WHEN status > 0 AND status < 100 THEN 1 ELSE 0 END) as in_progress')
            ->selectRaw('SUM(CASE WHEN status = 100 THEN 1 ELSE 0 END) as completed')
            ->first();

        $this->stats = [
            'total' => $statsData->total ?? 0,
            'pending' => $statsData->pending ?? 0,
            'in_progress' => $statsData->in_progress ?? 0,
            'completed' => $statsData->completed ?? 0,
        ];
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function deleteRequest($id)
    {
        ServiceRequest::destroy($id);
        $this->loadInitialData(); // Refresh all data
        session()->flash('message', 'Service request deleted successfully.');
    }

    public function updateStatus($id, $status)
    {
        $request = ServiceRequest::find($id);
        if ($request) {
            $request->update([
                'status' => $status,
                'last_update' => now()
            ]);
            $this->loadInitialData(); // Refresh all data
            session()->flash('message', 'Status updated successfully.');
        }
    }

    public function assignTech($requestId, $technicianId)
    {
        $request = ServiceRequest::find($requestId);
        if ($request) {
            $request->update([
                'technician_id' => $technicianId,
                'receptioners_id' => Auth::guard('frontdesk')->user()->id,
                'last_update' => now()
            ]);

            // Refresh the data
            $this->loadInitialData();

            // Dispatch event to hide loading
            $this->dispatch('technicianAssigned');

            session()->flash('message', 'Technician assigned successfully.');
        }
    }


    public function render()
    {
        $requests = ServiceRequest::with(['technician'])
            ->where('franchise_id', $this->franchise_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('service_code', 'like', '%' . $this->search . '%')
                        ->orWhere('owner_name', 'like', '%' . $this->search . '%')
                        ->orWhere('product_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('contact', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'in_progress') {
                    $query->where('status',25);
                } elseif ($this->statusFilter == 'completed') {
                    $query->where('status', 100);
                } elseif ($this->statusFilter == 'pending') {
                    $query->where('status', 0);
                } elseif ($this->statusFilter == 'rejected') {
                    $query->where('status', 90);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.frontdesk.manage-user-request', [
            'requests' => $requests,
            'stats' => $this->stats,
            'technicians' => $this->technicians,
        ]);
    }
}
