<?php

namespace App\Livewire\Admin\Solution;
use App\Models\Model;
use App\Models\Problem;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-layout')]
class ManageProblem extends Component
{
    use WithPagination;

    public $name;
    public $model_id;
    public $showFlash = false;
    public $editingProblemId = null;

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'model_id' => 'required|exists:models,id',
    ];

    public function saveProblem()
    {
        $this->validate();
        Problem::create([
            'name' => $this->name,
            'model_id' => $this->model_id, // Save the device_id as well
        ]);

        session()->flash('message', 'Device Created successfully');

        $this->resetForm();
    }

    public function deleteProblem($id)
    {
        Problem::findOrFail($id)->delete();
        session()->flash('message', 'Problem deleted successfully');
    }
    public function editProblem($id){
         $problem = Problem::findOrFail($id);
        $this->editingProblemId = $problem->id;
        $this->model_id = $problem->model_id;
        $this->name = $problem->name;
    }

     public function cancelEdit()
    {
        $this->editingProblemId = null;
        $this->name = null;
        $this->model_id = null;
    }

     public function updateBrand()
    {
        $this->validate();

        if ($this->editingProblemId) {
            $problem = Problem::findOrFail($this->editingProblemId);
            $problem->update(
                [
                    'name' => $this->name,
                    'model_id' => $this->model_id
                ]
            );
            $this->resetInput();
            session()->flash('message', 'Problem updated successfully');
        }
    }
    private function resetForm()
    {
        $this->reset(['name', 'model_id', 'editingProblemId']);
        $this->resetPage();
    }
    public function render()
    {
        $models = Model::all();
        $problems = Problem::orderBy('id', 'desc')->get();
        return view('livewire.admin.solution.manage-problem', [
            'models' => $models,
            'problems' => $problems,
        ]);
    }
}
