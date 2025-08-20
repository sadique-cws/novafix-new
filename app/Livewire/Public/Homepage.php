<?php

namespace App\Livewire\Public;

use Livewire\Component;
#[Title('Homepage')]

class Homepage extends Component
{
    public function render()
    {
        return view('livewire.public.homepage');
    }
}
