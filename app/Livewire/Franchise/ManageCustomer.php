<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Manage Customers')]
#[Layout('components.layouts.franchise-layout')]
class ManageCustomer extends Component
{
    public $search = '';

    public function render()
    {
        // Franchise ID from login
        $franchiseId = Auth::guard('franchise')->id();

        // Sirf us franchise ke customers dikhao
        $customers = Customer::query()
            ->withCount('serviceRequests')
            ->where('franchise_id', $franchiseId)
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('contact', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->get();

        return view('livewire.franchise.manage-customer', [
            'customers' => $customers,
        ]);
    }
}
