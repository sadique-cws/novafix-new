<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;

class ConfirmDeleteModal extends Component
{
    public $id;

    public function mount($idToDelete)
    {
        $this->id = $idToDelete;
    }
    public function render()
    {
        return view('livewire.admin.components.confirm-delete-modal');
    }

    public function delete()
    {
        $this->dispatch('confirmDelete', id: $this->id);
    }
}
