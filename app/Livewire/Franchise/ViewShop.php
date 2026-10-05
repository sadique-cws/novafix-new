<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\Shop;
use App\Models\Ledger;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('View Shop Ledger')]
#[Layout('components.layouts.franchise-layout')]
class ViewShop extends Component
{
    public $shop;
    public $settle_amount = 0;
    public $showSettleModal = false;

    public function mount($id)
    {
        $franchiseId = Auth::guard('franchise')->id();
        
        $this->shop = Shop::with(['ledgers' => function($query) {
            $query->latest();
        }, 'ledgers.serviceRequest'])
        ->where('franchise_id', $franchiseId)
        ->findOrFail($id);

        $this->shop->refreshBalance();
    }

    public function settleDues()
    {
        $this->validate([
            'settle_amount' => 'required|numeric|min:1',
        ]);

        $franchiseId = Auth::guard('franchise')->id();
        $adminId = Auth::id();

        Ledger::create([
            'franchise_id' => $franchiseId,
            'shop_id' => $this->shop->id,
            'type' => 'credit',
            'amount' => $this->settle_amount,
            'description' => 'Payment Collected',
            'recorded_by' => $adminId,
            'recorded_by_type' => 'admin'
        ]);

        $this->dispatch('close-modal', name: 'settleModal');
        $this->settle_amount = 0;
        
        $this->shop->refreshBalance();
        $this->shop->load(['ledgers' => function($query) {
            $query->latest();
        }, 'ledgers.serviceRequest']);
        
        session()->flash('success', 'Payment recorded successfully!');
    }

    public function render()
    {
        return view('livewire.franchise.view-shop');
    }
}
