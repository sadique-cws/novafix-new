<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-layout')]
class FranchiseServiceRequests extends Component
{
    use WithPagination;

    public $franchise_id;
    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $franchise;

    public function mount($id)
    {
        $this->franchise_id = $id;
        $this->franchise = Franchise::findOrFail($id);
    }

    public function render()
    {
        $requests = ServiceRequest::with(['technician', 'receptioner', 'category'])
            ->where('franchise_id', $this->franchise_id)
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('service_code', 'like', '%' . $this->search . '%')
                      ->orWhere('owner_name', 'like', '%' . $this->search . '%')
                      ->orWhere('contact', 'like', '%' . $this->search . '%')
                      ->orWhere('product_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.franchise-service-requests', [
            'requests' => $requests,
        ])->title($this->franchise->franchise_name . ' - Bookings');
    }
}
