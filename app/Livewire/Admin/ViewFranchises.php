<?php

namespace App\Livewire\Admin;

use App\Models\Franchise; // Changed to proper PascalCase
use App\Models\franchises;
use Livewire\Component;

class ViewFranchises extends Component
{
    public $franchise; // Define the property to hold single franchise

    public function mount($id = null) // Make ID optional if needed
    {
        if ($id) {
            $this->franchise = franchises::findOrFail($id); // Get single franchise
        } else {
            // Optionally handle case when no ID is provided
            $this->franchise = null;
        }
    }

    public function render()
    {
        return view('livewire.admin.view-franchises', [
            'franchise' => $this->franchise // Pass the single franchise to view
        ]);
    }
}
