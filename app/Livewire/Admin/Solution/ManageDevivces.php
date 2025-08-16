<?php

namespace App\Livewire\Admin\Solution;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ManageDevivces extends Component
{
    #[Layout('components.layouts.admin-layout')]
    public function render()
    {
        return view('livewire.admin.solution.manage-devivces');
    }
}
