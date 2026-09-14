<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('View Customer')]
#[Layout('components.layouts.franchise-layout')]
class ViewCustomer extends Component
{
    public $customer;

    public function mount($id)
    {
        $franchiseId = Auth::guard('franchise')->id();
        
        $this->customer = Customer::with(['serviceRequests' => function($query) {
            $query->latest();
        }])
        ->where('franchise_id', $franchiseId)
        ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.franchise.view-customer');
    }
}
