<?php

namespace App\Livewire\Franchise;

use App\Models\Receptioners;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.franchise-layout')]
class ManageReceptioners extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'desc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }
    public function view($id)
    {
        return $this->redirect(route('franchise.view.receptionist', $id), navigate: true);
    }
    public function render()
    {
        return view('livewire.franchise.manage-receptioners', [
            'receptionists' => Receptioners::query()
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('contact', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }
    public function logout()
    {
        Auth::guard('franchise')->logout();
        return redirect()->route('franchise.login');
    }
}
