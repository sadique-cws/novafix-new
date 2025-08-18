<?php

namespace App\Livewire\Admin\Solution;

use App\Models\Brand;
use App\Models\Device;
use App\Models\Model;
use App\Models\Problem;
use App\Models\Question;
use App\Models\userAnswer;
use Auth;
use Livewire\Component;

class ProductDetail extends Component
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
    public $newQuestionText;
    public $newQuestionAnswer;
    public $editingQuestionId = null;
    public $editingQuestionText = '';


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
        $this->currentQuestion = Question::where('problem_id', $this->selectedProblem)->first();

        if ($this->currentQuestion) {
            $this->loadQuestionTree();
        }
    }
    public function loadQuestionTree()
    {
        $this->questionTree = $this->buildTree($this->currentQuestion);
    }

    private function buildTree($question)
    {
        if (!$question)
            return null;

        return [
            'text' => $question->question_text,
            'yes' => $question->yes_question_id ? $this->buildTree(Question::find($question->yes_question_id)) : null,
            'no' => $question->no_question_id ? $this->buildTree(Question::find($question->no_question_id)) : null,
        ];
    }

    public function createQuestion()
    {
        $this->validate(['newQuestionText' => 'required|string']);

        $newQuestion = Question::create([
            'problem_id' => $this->selectedProblem,
            'question_text' => $this->newQuestionText,
        ]);

        if ($this->newQuestionAnswer === 'yes') {
            $this->currentQuestion->yes_question_id = $newQuestion->id;
        } else {
            $this->currentQuestion->no_question_id = $newQuestion->id;
        }

        $this->currentQuestion->save();

        if (!$this->currentQuestion->yes_question_id || !$this->currentQuestion->no_question_id) {
            $this->newQuestionAnswer = $this->newQuestionAnswer === 'yes' ? 'no' : null;
            $this->newQuestionText = '';
        } else {
            $this->currentQuestion = Question::find($this->currentQuestion->id);
            $this->newQuestionAnswer = null;
        }
    }
    public function cancelCreateQuestion()
    {
        // Reset all the question creation related properties
        $this->newQuestionAnswer = null;
        $this->newQuestionText = '';
    }

    public function createFirstQuestion()
    {
        $this->validate(['newQuestionText' => 'required|min:3']);
        $this->currentQuestion = Question::create([
            'problem_id' => $this->selectedProblem,
            'question_text' => $this->newQuestionText,
        ]);
        $this->newQuestionText = '';
    }
    public function editQuestion($questionId)
    {
        $question = Question::find($questionId);
        if ($question) {
            $this->editingQuestionId = $questionId;
            $this->editingQuestionText = $question->question_text;
        }
    }
    public function updateQuestion()
    {
        $this->validate(['editingQuestionText' => 'required|min:3']);

        $question = Question::find($this->editingQuestionId);
        if (!$question) {
            session()->flash('error', 'Question not found');
            return;
        }
        $question->update(['question_text' => $this->editingQuestionText]);
        $this->editingQuestionId = null;
        $this->editingQuestionText = '';
        $this->currentQuestion = $question;

        session()->flash('message', 'question Updated Successfully');
    }
    public function cancelEdit()
    {
        $this->editingQuestionId = null;
        $this->editingQuestionText = '';
    }
    public function answerQuestion($answer)
    {
        if (!$this->currentQuestion)
            return;

        userAnswer::create([
            'user_id' => 1,
            'question_id' => $this->currentQuestion->id,
            'device_id' => $this->selectedDevice,
            'brand_id' => $this->selectedBrand,
            'model_id' => $this->selectedModel,
            'problem_id' => $this->selectedProblem,
            'selected_answer' => $answer
        ]);

        if ($answer === 'yes' && $this->currentQuestion->yes_question_id) {
            $this->currentQuestion = Question::find($this->currentQuestion->yes_question_id);
        } elseif ($answer === 'no' && $this->currentQuestion->no_question_id) {
            $this->currentQuestion = Question::find($this->currentQuestion->no_question_id);
        } else {
            $this->newQuestionText = '';
            $this->newQuestionAnswer = $answer;
        }
    }
    public function previousQuestion()
    {
        $parentQuestion = Question::where('yes_question_id', $this->currentQuestion->id)
            ->orWhere('no_question_id', $this->currentQuestion->id)
            ->first();

        if ($parentQuestion) {
            $this->currentQuestion = $parentQuestion;
        }
    }
    public function resetSelection()
    {
        $this->selectedDevice = null;
        $this->selectedBrand = null;
        $this->selectedModel = null;
        $this->selectedProblem = null;
        $this->currentQuestion = null;
        $this->newQuestionText = null;
        $this->newQuestionAnswer = null;

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
        return view('livewire.admin.solution.product-detail', [
            'showCreateFirst' => !$this->currentQuestion,
            'showAddQuestion' => $this->currentQuestion && (!$this->currentQuestion->yes_question_id || !$this->currentQuestion->no_question_id),
        ]);
    }
}
