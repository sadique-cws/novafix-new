<?php

namespace App\Livewire\Admin\Solution;

use App\Models\Device;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ManageDevice extends Component
{
     public $name;
    protected $rules = [
        'name' => 'required|string',
    ];

    public function addDevice()
    {
        $this->validate();
        Device::create(['name' => $this->name]);

        $this->resetInput();
        session()->flash('message', 'Device Created successfully');
    }

    public function deleteDevice($id)
    {
        Device::findOrFail($id)->delete();
        session()->flash('message', 'Device Created successfully');
    }

    public function resetInput()
    {
        $this->name = '';
    }
    #[Layout('components.layouts.admin-layout')]
    public function render()
    {
        $devices = Device::orderBy('id', 'desc')->get();
        return view('livewire.admin.solution.manage-device', compact('devices'));
    }
}
