<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.franchise-layout')]

class RepairRequest extends Component
{
    public $requests;

    public function mount()
    {
        // मान लीं कि franchise_id लॉगिन user टेबल में बा
        $franchiseId = Auth::guard('franchise')->user()->id;

        // ओही फ्रेंचाइज़ के service requests लऽ
        $this->requests = ServiceRequest::where('franchise_id', $franchiseId)->get();
    }

    public function render()
    {
        return view('livewire.franchise.repair-request', [
            'requests' => $this->requests
        ]);
    }
}
