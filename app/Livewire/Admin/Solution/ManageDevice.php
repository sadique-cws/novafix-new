<?php

namespace App\Livewire\Admin\Solution;

use App\Models\Device;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ManageDevice extends Component
{
    use WithPagination;

    public $name;
    public $editingId = null;
    protected $rules = [
        'name' => 'required|unique:devices,name|string',
    ];
    public $showFlash = false;

    public $showDeleteModal = false;
    public $idToDelete;
    public $search = '';

    #[On('openConfirmDeleteModal')]
    public function openDeleteModal($id)
    {
        $this->idToDelete = $id;
        $this->showDeleteModal = true;
    }

    #[On('closeDeleteModal')]
    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    #[On('confirmDelete')]
    public function handleConfirmDelete($id)
    {
        $this->deleteDevice($id);
    }

    public function deleteDevice($idToDelete)
    {
        Device::findOrFail($idToDelete)->delete();
        $this->closeDeleteModal();
        session()->flash('message', 'Device Deleted successfully');
    }

    public function addDevice()
    {
        $this->validate();
        Device::create(['name' => $this->name]);

        $this->resetInput();
        session()->flash('message', 'Device Created successfully');
    }

    public function editDevice($id)
    {
        $device = Device::findOrFail($id);
        $this->editingId = $device->id;
        $this->name = $device->name;
    }

    public function updateDevice()
    {
        $this->validate();

        if ($this->editingId) {
            $device = Device::findOrFail($this->editingId);
            $device->update(['name' => $this->name]);

            $this->resetInput();
            session()->flash('message', 'Device updated successfully');
        }
    }

    public function resetInput()
    {
        $this->name = '';
        $this->editingId = null;
    }
    #[Layout('components.layouts.admin-layout')]
    public function render()
    {
        $devices = Device::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->latest()->paginate(5);
        return view('livewire.admin.solution.manage-device', compact('devices'));
    }
}
