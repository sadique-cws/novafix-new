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
    public $total_dues = 0;
    public $settle_amount = 0;
    public $showSettleModal = false;

    public function mount($id)
    {
        $franchiseId = Auth::guard('franchise')->id();
        
        $this->shop = Shop::with(['serviceRequests.payment' => function($query) {
            $query->latest();
        }])
        ->where('franchise_id', $franchiseId)
        ->findOrFail($id);

        $this->calculateDues();
    }

    public function calculateDues()
    {
        $this->total_dues = 0;
        foreach ($this->shop->serviceRequests as $sr) {
            if ($sr->payment && $sr->payment->due_amount > 0) {
                $this->total_dues += $sr->payment->due_amount;
            }
        }
    }

    public function settleDues()
    {
        $this->validate([
            'settle_amount' => 'required|numeric|min:1|max:' . $this->total_dues,
        ]);

        $remaining_to_settle = (float) $this->settle_amount;
        $franchiseId = Auth::guard('franchise')->id();
        $adminId = Auth::id(); // Typically the staff/admin id

        // Order service requests by oldest first to clear older dues first
        $serviceRequests = $this->shop->serviceRequests()->with('payment')->oldest()->get();

        foreach ($serviceRequests as $sr) {
            if ($remaining_to_settle <= 0) break;

            if ($sr->payment && $sr->payment->due_amount > 0) {
                $due = (float) $sr->payment->due_amount;
                
                $pay_for_this_bill = min($due, $remaining_to_settle);
                
                // Record the transaction
                \App\Models\PaymentTransaction::create([
                    'payment_id' => $sr->payment->id,
                    'service_request_id' => $sr->id,
                    'amount_paid' => $pay_for_this_bill,
                    'payment_method' => 'cash',
                    'staff_id' => $adminId,
                    'notes' => 'Bulk Settlement via Shop Ledger',
                ]);

                // Update the payment record
                $new_paid = (float) $sr->payment->paid_amount + $pay_for_this_bill;
                $new_due = (float) $sr->payment->total_amount - $new_paid;
                
                $status = $new_due <= 0 ? 'completed' : 'partial';

                $sr->payment->update([
                    'paid_amount' => $new_paid,
                    'due_amount' => max($new_due, 0),
                    'status' => $status,
                ]);

                $remaining_to_settle -= $pay_for_this_bill;
            }
        }

        $this->dispatch('close-modal', 'settleModal');
        $this->settle_amount = 0;
        
        // Refresh data
        $this->shop->refresh();
        $this->calculateDues();
        
        session()->flash('success', 'Dues settled successfully!');
    }

    public function render()
    {
        return view('livewire.franchise.view-shop');
    }
}
