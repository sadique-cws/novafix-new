<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('view Franchise')]
#[Layout('components.layouts.admin-layout')]

class ViewFranchises extends Component
{
    public $franchise;

    public function mount($id = null)
    {
        if ($id) {
            $this->franchise = Franchise::find($id);
        }
    }

    public function render()
    {
        return view('livewire.admin.view-franchises', [
            'franchise' => $this->franchise
        ]);
    }
}
