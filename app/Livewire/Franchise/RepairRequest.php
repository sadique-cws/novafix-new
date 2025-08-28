<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.franchise-layout')]
class RepairRequest extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        // reset to first page if you add pagination later
    }

    public function render()
    {
        $requests = ServiceRequest::query()
            ->where('franchise_id', Auth::guard('franchise')->user()->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('owner_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('contact', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        return view('livewire.franchise.repair-request', [
            'requests' => $requests
        ]);
    }
}
