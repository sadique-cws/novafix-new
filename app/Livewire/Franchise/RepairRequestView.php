<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\ServiceRequest;
use App\Models\Receptioner;
use App\Models\Receptioners;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.franchise-layout')]
class RepairRequestView extends Component
{
    public $request;
    public $receptioners;
    public $receptioner_id;

    public function mount($id)
    {
        $franchiseId = Auth::guard('franchise')->user()->id;

        // Request लऽ (ओही franchise का)
        $this->request = ServiceRequest::where('franchise_id', $franchiseId)
            ->where('id', $id)
            ->firstOrFail();

        // सिर्फ़ ओही franchise के receptioners लऽ
        $this->receptioners = Receptioners::where('franchise_id', $franchiseId)->get();

        // अगर पहले से assign बा
        $this->receptioner_id = $this->request->receptioners_id;
    }

    public function updateReceptioner()
    {
        $this->request->update([
            'receptioners_id' => $this->receptioner_id,
        ]);

        session()->flash('success', 'Receptioner updated successfully.');
    }

    public function render()
    {
        return view('livewire.franchise.repair-request-view');
    }
}
