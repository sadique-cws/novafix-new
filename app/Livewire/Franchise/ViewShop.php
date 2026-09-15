<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('View Shop')]
#[Layout('components.layouts.franchise-layout')]
class ViewShop extends Component
{
    public $shop;

    public function mount($id)
    {
        $franchiseId = Auth::guard('franchise')->id();
        
        $this->shop = Shop::with(['serviceRequests' => function($query) {
            $query->latest();
        }])
        ->where('franchise_id', $franchiseId)
        ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.franchise.view-shop');
    }
}
