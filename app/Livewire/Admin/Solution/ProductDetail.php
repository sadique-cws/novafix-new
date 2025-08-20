<?php

namespace App\Livewire\Admin\Solution;

use App\Helpers\ImageKitHelper;
use App\Models\Brand;
use App\Models\Device;
use App\Models\Model;
use App\Models\Problem;
use App\Models\Question;
use App\Models\userAnswer;
use Auth;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductDetail extends Component
{
    use WithFileUploads;
    public $image;
    public $description;
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
    public $editingQuestionImage = null;
    public $editingQuestionDescription = '';
    public $search = '';
    public $isSearching = false;
    public $question = [];
    public $selectedQuestion;
    public $creatingNew = false;
    public $allQuestion = [];
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
    // {{--enter Search by Question Text-- }}
    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->allQuestion = [];
            return;
        }
        $this->allQuestion = Question::where('question_text', 'like', '%' . $this->search . '%')
        ->whereNot('id',$this->currentQuestion->id)
            ->take(5)
            ->get();
    }
    public function selectQuestion($questionId)
    {
        $this->selectedQuestion = Question::find($questionId);
        $this->creatingNew = false;
        $this->search = '';
        $this->allQuestion = [];
    }
    public function clearSelection()
    {
        $this->selectedQuestion = null;
        $this->creatingNew = false;
        $this->search = '';
        $this->reset(['image', 'description']);
    }
    public function createNewQuestion()
    {
        $this->creatingNew = true;
        $this->selectedQuestion = null;
        $this->reset(['image', 'description', 'newQuestionText']);
    }
    public function cancelCreate()
    {
        $this->creatingNew = false;
        $this->reset(['image', 'description', 'newQuestionText']);
    }
    public function createQuestion()
    {
        // If we have a selected question from search, update it instead of creating new
        if ($this->selectedQuestion) {
            // Update the relationship in the current question
            if ($this->newQuestionAnswer === 'yes') {
                $this->currentQuestion->yes_question_id = $this->selectedQuestion->id;
            } else {
                $this->currentQuestion->no_question_id = $this->selectedQuestion->id;
            }
            $this->currentQuestion->save();

        } else {
            $this->validate([
                'newQuestionText' => 'required|min:3',
                'image' => 'nullable|image|max:1024',
                'description' => 'nullable|string'
            ]);
            // Original logic for creating a new question
            $newQuestionData = [
                'problem_id' => $this->selectedProblem,
                'question_text' => $this->newQuestionText,
                'description' => $this->description
            ];

            if ($this->image) {
                $imageData = ImageKitHelper::uploadImage($this->image, '/Novafix/Question_image');

                if ($imageData) {
                    $newQuestionData['image_url'] = $imageData['url'];
                    $newQuestionData['image_file_id'] = $imageData['fileId'];
                } else {
                    session()->flash('error', 'Failed to upload image, please try again');
                    return;
                }
            }

            $newQuestion = Question::create($newQuestionData);

            if ($this->newQuestionAnswer === 'yes') {
                $this->currentQuestion->yes_question_id = $newQuestion->id;
            } else {
                $this->currentQuestion->no_question_id = $newQuestion->id;
            }

            $this->currentQuestion->save();
        }

        $this->description = '';
        $this->image = null;

        if (!$this->currentQuestion->yes_question_id || !$this->currentQuestion->no_question_id) {
            $this->newQuestionAnswer = $this->newQuestionAnswer === 'yes' ? 'no' : null;
            $this->newQuestionText = '';
        } else {
            $this->currentQuestion = Question::find($this->currentQuestion->id);
            $this->newQuestionAnswer = null;
        }

        // Reset selected question after processing
        $this->selectedQuestion = null;
        $this->search = '';
        $this->creatingNew = false;
    }
    public function cancelCreateQuestion()
    {
        // Reset all the question creation related properties
        $this->newQuestionAnswer = null;
        $this->newQuestionText = '';
    }
    public function createFirstQuestion()
    {
        $this->validate([
            'newQuestionText' => 'required|min:3',
            'image' => 'nullable|image|max:1024',
            'description' => 'nullable|string'
        ]);
        $questionData = [
            'problem_id' => $this->selectedProblem,
            'question_text' => $this->newQuestionText,
            'description' => $this->description,
        ];

        if ($this->image) {
            $imageData = ImageKitHelper::uploadImage($this->image, '/Novafix/Question_image');

            if ($imageData) {
                $questionData['image_url'] = $imageData['url'];
                $questionData['image_file_id'] = $imageData['fileId'];
            } else {
                session()->flash('error', 'failed to upload image, please try again');
                return;
            }
        }
        $this->currentQuestion = Question::create($questionData);
        $this->newQuestionText = '';
    }
    public function editQuestion($questionId)
    {
        $question = Question::find($questionId);
        if ($question) {
            $this->editingQuestionId = $questionId;
            $this->editingQuestionText = $question->question_text;
            $this->editingQuestionImage = $question->image_url;
            $this->editingQuestionDescription = $question->description;
        }
    }
    public function updateQuestion()
    {
        $this->validate([
            'editingQuestionText' => 'required|min:3',
            'image' => 'nullable|image|max:1024',
            'description' => 'nullable|string'
        ]);

        $question = Question::find($this->editingQuestionId);
        if (!$question) {
            session()->flash('error', 'Question not found');
            return;
        }
        $updateData = [
            'question_text' => $this->editingQuestionText,
            'description' => $this->editingQuestionDescription,
        ];
        // Handle image upload if a new image was provided
        if ($this->image) {
            $imageData = ImageKitHelper::uploadImage($this->image, '/Novafix/Question_image');

            if ($imageData) {
                // Delete old image from ImageKit if it exists
                if ($question->image_file_id) {
                    ImageKitHelper::deleteImage($question->image_file_id);
                }

                $updateData['image_url'] = $imageData['url'];
                $updateData['image_file_id'] = $imageData['fileId'];
            } else {
                session()->flash('error', 'Failed to upload image, please try again');
                return;
            }
        }



        $question->update($updateData);
        $this->editingQuestionId = null;
        $this->editingQuestionText = '';
        $this->editingQuestionImage = null;
        $this->editingQuestionDescription = '';
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
            'user_id' => Auth::id(),
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
        $this->description = '';
        $this->image = null;

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
        $allQuestion = Question::all();
        return view('livewire.admin.solution.product-detail', [
            'showCreateFirst' => !$this->currentQuestion,
            'showAddQuestion' => $this->currentQuestion && (!$this->currentQuestion->yes_question_id || !$this->currentQuestion->no_question_id),
            'allQuestion' => $allQuestion,
        ]);
    }
}
