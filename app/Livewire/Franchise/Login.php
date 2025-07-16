<?php

namespace App\Livewire\Franchise;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{   
     #[Layout('components.layouts.franchise-layout')]
    public function render()
    {
        return view('livewire.franchise.login');
    }
}
