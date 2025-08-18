<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Franchise;
use App\Models\Staff;
use App\Models\ServiceCategory;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-layout')]
class StaffManage extends Component
{
    use WithPagination;

    public $search = '';
    public $franchiseFilter = '';
    public $categoryFilter = '';
    public $sortField = 'name'; // Add this
    public $sortDirection = 'asc'; // Add this

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $staff = Staff::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('contact', 'like', '%' . $this->search . '%');
            })
            ->when($this->franchiseFilter, function ($query) {
                $query->where('franchise_id', $this->franchiseFilter);
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('service_categories_id', $this->categoryFilter);
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->with(['franchise', 'serviceCategory'])
            ->paginate(10);

        $franchises = franchises::orderBy('franchise_name')->get();
        $categories = ServiceCategory::orderBy('name')->get();

        return view('livewire.admin.staff-manage', [
            'staffs' => $staff,
            'franchises' => $franchises,
            'categories' => $categories,
        ]);
    }
}
