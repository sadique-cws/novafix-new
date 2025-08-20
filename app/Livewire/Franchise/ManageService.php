<?php

namespace App\Livewire\Franchise;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\ServiceCategory;
#[Title('Manage Services')]
#[Layout('components.layouts.franchise-layout')]

class ManageService extends Component
{
    public $showAddModal = false;
    public $categoryName = '';
    public $categories = [];
    public $editId = null;

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = ServiceCategory::all();
    }

    #[On('startAdd')]
    public function viewAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function addCategory()
    {
        $validated = $this->validate([
            'categoryName' => 'required|string|max:255|unique:service_categories,name'
        ]);

        if ($this->editId) {
            $category = ServiceCategory::find($this->editId);
            $category->update(['name' => $validated['categoryName']]);
            session()->flash('message', 'Category updated successfully.');
        } else {
            ServiceCategory::create(['name' => $validated['categoryName']]);
            session()->flash('message', 'Category added successfully.');
        }

        $this->closeModal();
        $this->loadCategories();
    }

    public function startEdit($id)
    {
        $category = ServiceCategory::find($id);
        if ($category) {
            $this->editId = $id;
            $this->categoryName = $category->name;
            $this->showAddModal = true;
        }
    }

   
    public function deleteCategory($id)
    {
        ServiceCategory::destroy($id);
        session()->flash('message', 'Category deleted successfully.');
        $this->loadCategories();
    }

    public function closeModal()
    {
        $this->showAddModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->categoryName = '';
        $this->editId = null;
    }

    public function render()
    {
        return view('livewire.franchise.manage-service');
    }
}
