<?php

namespace App\Livewire\Admin;

use App\Models\Franchise;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ManageFranchises extends Component

{
    #[Layout('components.layouts.admin-layout')]


    public $search = '';
    public $statusFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
  
    public function edit($id){
        return redirect(route('admin.edit-franchise', ['id' => $id]));
    }

    public function render()
    {

        $franchises = Franchise::query()
            ->when($this->search, function ($query) {
                $query->where('franchise_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('contact_no', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.manage-franchises', [
            'franchises' => $franchises,
        ]);
    }
}
