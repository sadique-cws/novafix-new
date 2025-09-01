<?php

namespace App\Livewire\Admin\Solution;

use App\Models\Brand;
use App\Models\Device;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-layout')]
class ManageBrand extends Component
{
    use WithPagination;

    public $editingId = null;
    public $showFlash = false;
    public $name;
    public $device_id;
    public $search = '';

    protected $rules = [
        'name' => 'required|string',
        'device_id' => 'required|exists:devices,id',
    ];

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addBrand()
    {
        $this->validate();
        Brand::create([
            'name' => $this->name,
            'device_id' => $this->device_id,
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
            $brand->update([
                'name' => $this->name,
                'device_id' => $this->device_id
            ]);
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
        $devices = Device::all();
        $brands = Brand::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.admin.solution.manage-brand', [
            'devices' => $devices,
            'brands' => $brands,
        ]);
    }
}
