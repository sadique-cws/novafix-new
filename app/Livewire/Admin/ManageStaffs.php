<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use App\Models\Staff;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Title('Manage Staffs')]
#[Layout('components.layouts.admin-layout')]

class ManageStaffs extends Component
{
    use WithPagination;

    public $franchise_id;
    public $status;
    public $search = '';
    public $sortBy = 'name';
    public $sortAsc = true;

    public function mount()
    {
        $this->status = 'active';
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortBy = $field;
    }


    public function render()
    {
        $staffs = Staff::query()
            ->when($this->franchise_id, function ($query) {
                $query->where('franchise_id', $this->franchise_id);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->search(trim($this->search))
            ->orderBy($this->sortBy, $this->sortAsc ? 'asc' : 'desc')
            ->paginate(10);

        $franchises = Franchise::all();

        return view('livewire.admin.manage-staffs', [
            'staffs' => $staffs,
            'franchises' => $franchises,
        ]);
    }
}
