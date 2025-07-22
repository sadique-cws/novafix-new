<?php

namespace App\Livewire\Frontdesk;

use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.frontdesk-layout')]
class CompletedTask extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage'
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection == 'asc';
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
        $requests = ServiceRequest::query()
            ->where('receptioners_id', Auth::guard('frontdesk')->user()->id)
            ->where('status', 100) // Only completed tasks
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
        ]);
    }
}
