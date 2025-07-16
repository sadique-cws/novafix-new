<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use App\Models\franchises;
use Livewire\Component;

class ViewFranchises extends Component
{
    public $franchise;

    public function mount($id = null)
    {
        if ($id) {
            $this->franchise = franchises::find($id);
        }
    }

    public function render()
    {
        return view('livewire.admin.view-franchises', [
            'franchise' => $this->franchise
        ]);
    }
}
