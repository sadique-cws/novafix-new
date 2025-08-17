<?php
// App\Livewire\Admin\Solution\ManageModel.php
namespace App\Livewire\Admin\Solution;

use App\Models\Brand;
use App\Models\Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class ManageModel extends Component
{
    public $name;
    public $brand_id;
    public $editingModelId = null;

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'brand_id' => 'required|exists:brands,id',
    ];

    public function addModel()
    {
        $this->validate();

        if ($this->editingModelId) {
            $model = Model::findOrFail($this->editingModelId);
            $model->update([
                'name' => $this->name,
                'brand_id' => $this->brand_id,
            ]);
            session()->flash('message', 'Model updated successfully');
        } else {
            Model::create([
                'name' => $this->name,
                'brand_id' => $this->brand_id,
            ]);
            session()->flash('message', 'Model created successfully');
        }

        $this->resetForm();
    }

    public function editModel($id)
    {
        $model = Model::findOrFail($id);
        $this->editingModelId = $model->id;
        $this->name = $model->name;
        $this->brand_id = $model->brand_id;
    }

    public function deleteModel($id)
    {
        Model::findOrFail($id)->delete();
        session()->flash('message', 'Model deleted successfully');
    }

    private function resetForm()
    {
        $this->reset(['name', 'brand_id', 'editingModelId']);
    }

    public function render()
    {
        $brands = Brand::orderBy('name')->get();
        $models = Model::with('brand')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.solution.manage-model', [
            'brands' => $brands,
            'models' => $models,
        ]);
    }
}
