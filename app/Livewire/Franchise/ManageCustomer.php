<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Dashboard')]
#[Layout('components.layouts.franchise-layout')]
class ManageCustomer extends Component
{
    public $search = '';

    public function render()
    {
        // Franchise ID from login
        $franchiseId = Auth::guard('franchise')->id();

        // Sirf us franchise ke receptioners/technician se bane customers dikhao
        $customers = ServiceRequest::query()
            ->whereHas('technician', function ($q) use ($franchiseId) {
                $q->where('franchise_id', $franchiseId);
            })
            ->when($this->search, function ($query) {
                $query->where('owner_name', 'like', '%' . $this->search . '%')
                    ->orWhere('contact', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();

        return view('livewire.franchise.manage-customer', [
            'customers' => $customers,
        ]);
    }
}
