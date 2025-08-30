<?php

namespace App\Livewire\Admin\Solution;

use App\Models\Brand;
use App\Models\Device;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class ManageBrand extends Component
{
    public $editingId = null;
    public $showFlash = false;
    public $name;
    public $device_id; // New property to hold the device ID

    protected $rules = [
        'name' => 'required|string',
        'device_id' => 'required|exists:devices,id', // Ensure device_id is provided and exists
    ];
    public function addBrand()
    {
        $this->validate();
        Brand::create([
            'name' => $this->name,
            'device_id' => $this->device_id, // Save the device_id as well
        ]);
        $this->resetInput();
        session()->flash('message', 'Device Created successfully');
    }

    public function deleteBrand($id)
    {
        Brand::find($id)->delete();
    }
    public function editBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $this->editingId = $brand->id;
        $this->name = $brand->name;
        $this->device_id = $brand->device_id;
    }
    public function updateBrand()
    {
        $this->validate();

        if ($this->editingId) {
            $brand = Brand::findOrFail($this->editingId);
            $brand->update(
                [
                    'name' => $this->name,
                    'device_id' => $this->device_id
                ]
            );
            $this->resetInput();
            session()->flash('message', 'Brand updated successfully');
        }
    }

    public function resetInput()
    {
        $this->name = '';
        $this->device_id = '';
        $this->editingId = null;
    }
    public function render()
    {
        $devices = Device::all(); // Fetch all devices for the dropdown
        $brands = Brand::orderBy('id', 'desc')->get(); // Fetch all brands for display
        return view(
            'livewire.admin.solution.manage-brand',
            [
                'devices' => $devices,
                'brands' => $brands,
            ]
        );
    }
}
