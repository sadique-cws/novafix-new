<?php

namespace App\Livewire\Franchise;

use App\Models\Receptioners;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.franchise-layout')]

class ViewReceptioners extends Component
{
    public Receptioners $receptionist;

    public function mount($id)
    {
        $this->receptionist = Receptioners::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.franchise.view-receptioners');
    }
}
