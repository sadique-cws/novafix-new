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
    public $search = '';
    protected $queryString = ['search'];

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
        // Reset pagination when search changes
        session()->flash('message', 'Problem Created successfully');
        $this->resetPage();
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
    public function deleteProblem($id){
        Problem::find($id)->delete();
        session()->flash('message', 'Problem Deleted successfully');
    }

    public function updateProblem()
    {
        $this->validate();

        if ($this->editingProblemId) {
            $problem = Problem::findOrFail($this->editingProblemId);
            $problem->update([
                'name' => $this->name,
                'model_id' => $this->model_id,
            ]);
            $this->resetForm();
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
       $problems = Problem::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(5);
        return view('livewire.admin.solution.manage-problem', [
            'models' => $models,
            'problems' => $problems,
        ]);
    }
}
