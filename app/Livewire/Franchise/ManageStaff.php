<?php

namespace App\Livewire\Franchise;

use Livewire\Attributes\Layout;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.franchise-layout')]

class ManageStaff extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $selectedStaff = null;
    public $showEditModal = false;
    public $showDeleteModal = false;

    protected $queryString = ['search', 'perPage', 'sortField', 'sortDirection'];

    public function render()
    {
        $staffMembers = Staff::query()
            ->where('franchise_id', Auth::guard('franchise')->user()->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('contact', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.franchise.manage-staff', [
            'staffMembers' => $staffMembers
        ]);
    }
}
