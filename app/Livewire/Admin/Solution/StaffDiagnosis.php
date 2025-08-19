<?php

namespace App\Livewire\Admin\Solution;

use App\Models\Brand;
use App\Models\Device;
use App\Models\Model;
use App\Models\Problem;
use App\Models\Question;
use App\Models\userAnswer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class StaffDiagnosis extends Component
{
    public $devices;
    public $brands = [];
    public $models = [];
    public $problems = [];
    public $questionTree = [];
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
        $this->selectedBrand = null;
        $this->models = null;
        $this->problems = null;
    }
    public function updateSelectedBrand()
    {
        $this->models = Model::where('brand_id', $this->selectedBrand)->get();
        $this->selectedModel = null;
        $this->problems = null;
    }
    public function updateSelectedModel()
    {
        $this->problems = Problem::where('model_id', $this->selectedModel)->get();
        $this->selectedProblem = null;
    }
   public function updateSelectedProblem()
    {
        $this->currentQuestion = Question::where('problem_id', $this->selectedProblem)->first();
        $this->loadQuestionTree();
    }
    public function loadQuestionTree()
    {
        if (!$this->selectedProblem)
            return;

        $this->questionTree = $this->buildTree($this->currentQuestion);
    }
    private function buildTree($question)
    {
        if (!$question)
            return null;

        return [
            'text' => $question->question_text,
            'image' => $question->image_url,
            'description' => $question->description,
            'yes' => $question->yes_question_id ? $this->buildTree(Question::find($question->yes_question_id)) : null,
            'no' => $question->no_question_id ? $this->buildTree(Question::find($question->no_question_id)) : null,
        ];
    }
    public function previousQuestion(){
        $parentQuestion  = Question::where('yes_question_id',$this->currentQuestion->id)
        ->orWhere('no_question_id',$this->currentQuestion->id)
        ->first();

        if($parentQuestion){
            $this->currentQuestion = $parentQuestion;
        }
    }
    public function answerQuestion($answer){
        if(!$this->currentQuestion){
            return;
        }

        // save user's answer
        userAnswer::create([
            'user_id' => Auth::id(),
            'question_id' => $this->currentQuestion->id,
            'device_id' => $this->selectedDevice,
            'brand_id' => $this->selectedBrand,
            'model_id' => $this->selectedModel,
            'problem_id' => $this->selectedProblem,
            'selected_answer' => $answer
        ]);

        if($answer === 'yes' && $this->currentQuestion->yes_question_id){
            $this->currentQuestion = Question::find($this->currentQuestion->yes_question_id);
        } elseif ($answer === 'no' && $this->currentQuestion->no_question_id){
            $this->currentQuestion = Question::find($this->currentQuestion->no_question_id);
        } else{
            // no next question stop here
            $this->currentQuestion = null;
        }
    }
    public function resetSelection()
    {
        $this->selectedDevice = null;
        $this->selectedBrand = null;
        $this->selectedModel = null;
        $this->selectedProblem = null;

        // reload device
        $this->devices = Device::all();
        $this->brands = [];
        $this->models = [];
        $this->problems = [];
    }
    public function render()
    {
        return view('livewire.admin.solution.staff-diagnosis');
    }
}
