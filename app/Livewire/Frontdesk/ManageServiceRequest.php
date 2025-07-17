<?php

namespace App\Livewire\Frontdesk;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.frontdesk-layout')]
class ManageServiceRequest extends Component
{
    public function render()
    {
        return view('livewire.frontdesk.manage-service-request');
    }
}
