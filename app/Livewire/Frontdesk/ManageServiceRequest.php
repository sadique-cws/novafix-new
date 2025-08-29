<?php

namespace App\Livewire\Frontdesk;

use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequest;
use App\Models\Staff;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Manage Service Request')]
#[Layout('components.layouts.frontdesk-layout')]
class ManageServiceRequest extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $technicians = [];
    public $stats = [];
    
    protected $receptionistId;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage'
    ];

    public function mount()
    {
        $this->receptionistId = Auth::guard('frontdesk')->user()->id;
        $this->loadInitialData();
    }

    public function loadInitialData()
    {
        // Load technicians once
        $this->technicians = Staff::where('franchise_id', Auth::guard('franchise')->user()->id)->get();
        
        // Calculate all stats in a single query
        $statsData = ServiceRequest::where('receptioners_id', $this->receptionistId)
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

    public function render()
    {
        $requests = ServiceRequest::query()->where('status_request', 1)
            ->where('receptioners_id',  Auth::guard('frontdesk')->user()->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('service_code', 'like', '%' . $this->search . '%')
                        ->orWhere('owner_name', 'like', '%' . $this->search . '%')
                        ->orWhere('product_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'in_progress') {
                    $query->where('status', '>', 0)->where('status', '<', 100);
                } elseif ($this->statusFilter === 'completed') {
                    $query->where('status', 100);
                } elseif ($this->statusFilter === 'pending') {
                    $query->where('status', 0);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.frontdesk.manage-service-request', [
            'requests' => $requests,
            'stats' => $this->stats,
            'technicians' => $this->technicians,
            'total' => $this->stats['total'],
        ]);
    }

    public function deleteRequest($id)
    {
        ServiceRequest::destroy($id);
        $this->loadInitialData(); // Refresh all data
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Service request deleted successfully.']);
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
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Status updated successfully.']);
        }
    }

    public function assignTechnician($requestId, $technicianId)
    {
        $request = ServiceRequest::find($requestId);
        if ($request) {
            $request->update([
                'technician_id' => $technicianId,
                'last_update' => now()
            ]);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Technician assigned successfully.']);
        }
    }
}