<?php

namespace App\Livewire\Franchise;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.franchise-layout')]

class StaffEdit extends Component
{
    public function render()
    {
        return view('livewire.franchise.staff-edit');
    }
}
