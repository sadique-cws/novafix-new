<?php

namespace App\Livewire\Admin\Solution;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]

class ServiceSolution extends Component
{
    public function render()
    {
        return view('livewire.admin.solution.service-solution');
    }
}
