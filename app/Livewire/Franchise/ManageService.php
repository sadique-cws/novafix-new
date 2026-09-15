<?php

namespace App\Livewire\Franchise;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceCategory;
use Livewire\Attributes\Title;

#[Title('Manage Services')]
#[Layout('components.layouts.franchise-layout')]
class ManageService extends Component
{
    use WithPagination;

    public $showAddModal = false;
    public $categoryName = '';
    public $editId = null;
    public $search = '';
    public $perPage = 10;

    #[On('startAdd')]
    public function viewAddModal()
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'serviceModal');
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
    }

    public function startEdit($id)
    {
        $category = ServiceCategory::find($id);
        if ($category) {
            $this->editId = $id;
            $this->categoryName = $category->name;
            $this->dispatch('open-modal', 'serviceModal');
        }
    }

    public function deleteCategory($id)
    {
        ServiceCategory::destroy($id);
        session()->flash('message', 'Category deleted successfully.');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', 'serviceModal');
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->categoryName = '';
        $this->editId = null;
    }

    public function render()
    {
        $categories = ServiceCategory::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.franchise.manage-service', [
            'categories' => $categories
        ]);
    }
}
