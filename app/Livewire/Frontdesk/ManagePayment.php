<?php

namespace App\Livewire\Frontdesk;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.frontdesk-layout')]


class ManagePayment extends Component
{
    public function render()
    {
        $payments = Payment::where('received_by', Auth::guard('frontdesk')->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); 
        return view('livewire.frontdesk.manage-payment', [
            'payments' => $payments,
        ]);
    }
}
