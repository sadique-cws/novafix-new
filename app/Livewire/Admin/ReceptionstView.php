<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Receptioner;
use App\Models\Receptioners;
#[Title('View Receptionist')]
#[Layout('components.layouts.admin-layout')]
class ReceptionstView extends Component
{
    public Receptioners $receptionist;

    public function mount($id)
    {
        $this->receptionist = Receptioners::with('franchise')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.receptionst-view');
    }
}
