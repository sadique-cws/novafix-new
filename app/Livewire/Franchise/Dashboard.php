<?php

namespace App\Livewire\Franchise;

use App\Models\franchises;
use App\Models\Receptioners;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.franchise-layout')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.franchise.dashboard');
    }
}
