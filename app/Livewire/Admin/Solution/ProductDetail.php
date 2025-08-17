<?php

namespace App\Livewire\Admin\Solution;

use App\Models\Brand;
use App\Models\Device;
use App\Models\Model;
use App\Models\Problem;
use Livewire\Component;

class ProductDetail extends Component
{

    public $devices;
    public $brands = [];
    public $models = [];
    public $problems = [];
    public $selectedDevice;
    public $selectedBrand;
    public $selectedModel;
    public $selectedProblem;
    public $currentQuestion;


    public function mount()
    {
        $this->devices = Device::all();
    }

    public function updateSelectedDevice()
    {
        $this->brands = Brand::where('device_id', $this->selectedDevice)->get();
        $this->resetSelections(['brand', 'model']);
    }
    public function updateSelectedBrand()
    {
        $this->models = Model::where('brand_id', $this->selectedBrand)->get();
    }
    public function updateSelectedModel()
    {
        $this->problems = Problem::where('model_id', $this->selectedModel)->get();
    }
    public function updateSelectedProblem()
    {

    }

    public function resetSelection()
    {
        $this->selectedDevice = null;
        $this->selectedBrand = null;
        $this->selectedModel = null;
        $this->selectedProblem = null;

        // reload devices
        $this->devices = Device::all();
        $this->brands = [];
        $this->models = [];
        $this->problems = [];
    }

    private function resetSelections($fields)
    {
        foreach ($fields as $field) {
            $this->{'selected' . ucfirst($field)} = null;
        }
    }
    public function render()
    {
        return view('livewire.admin.solution.product-detail');
    }
}
