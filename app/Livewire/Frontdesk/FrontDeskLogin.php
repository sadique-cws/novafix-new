<?php

namespace App\Livewire\Frontdesk;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.frontdesk-layout')]
class FrontDeskLogin extends Component
{
    public function render()
    {
        return view('livewire.frontdesk.front-desk-login');
    }
}
