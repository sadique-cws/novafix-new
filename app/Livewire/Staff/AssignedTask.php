<?php

namespace App\Livewire\Staff;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.staff-layout')]
#[Title('Assigned Tasks')]

class AssignedTask extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage'
    ];

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
            ->where('technician_id', Auth::guard('staff')->user()->id) // Only show tasks assigned to current staff member
            ->with(['receptionist']) // Eager load the receptionist relationship
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
                    $query->where('status', 1);
                } elseif ($this->statusFilter === 'completed') {
                    $query->where('status', 2);
                } elseif ($this->statusFilter === 'pending') {
                    $query->where('status', 0);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.staff.assigned-task', [
            'requests' => $requests
        ]);
    }

    public function updateStatus($id, $status)
    {
        $request = ServiceRequest::find($id);
        if ($request) {
            $request->update([
                'status' => $status,
                'last_update' => now()
            ]);
            session()->flash('message', 'Status updated successfully.');
        }
    }

    public function markAsComplete($id = null)
    {
        if (!$id) {
            return;
        }

        $request = ServiceRequest::find($id);
        if ($request) {
            $request->update([
                'status' => 2,
                'last_update' => now()
            ]);
            session()->flash('message', 'Task marked as completed successfully.');
        }
    }
}
