<?php

namespace App\Livewire\Frontdesk;

use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequest;
use App\Models\Staff;
use Livewire\Attributes\Layout;
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

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage'
    ];

    public function mount()
    {
        $this->technicians = Staff::where('id')->get();
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
        $requests = ServiceRequest::query()
            ->where('receptioners_id', Auth::guard('frontdesk')->user()->id)
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

        $stats = [
            'total' => ServiceRequest::where('receptioners_id', Auth::guard('frontdesk')->user()->id)->count(),
            'pending' => ServiceRequest::where('receptioners_id', Auth::guard('frontdesk')->user()->id)->where('status', 0)->count(),
            'in_progress' => ServiceRequest::where('receptioners_id', Auth::guard('frontdesk')->user()->id)->where('status', '>', 0)->where('status', '<', 100)->count(),
            'completed' => ServiceRequest::where('receptioners_id', Auth::guard('frontdesk')->user()->id)->where('status', 100)->count(),
        ];
        $total = ServiceRequest::where('receptioners_id', Auth::guard('frontdesk')->user()->id)->count();
    

        return view('livewire.frontdesk.manage-service-request', [
            'requests' => $requests,
            'stats' => $stats,
            'technicians' => $this->technicians,
            'total' => $total,

        ]);
    }

    public function deleteRequest($id)
    {
        ServiceRequest::destroy($id);
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
