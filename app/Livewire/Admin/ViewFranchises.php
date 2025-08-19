<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ViewFranchises extends Component
{
    #[Layout('components.layouts.admin-layout')]

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
