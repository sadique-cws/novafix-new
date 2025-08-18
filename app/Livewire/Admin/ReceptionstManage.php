<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Franchise;
use App\Models\Receptioner;
use App\Models\Receptioners;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-layout')]
class ReceptionstManage extends Component
{
    use WithPagination;

    public $search = '';
    public $franchiseFilter = '';

    public function render()
    {
        $receptionists = Receptioners::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('contact', 'like', '%' . $this->search . '%');
            })
            ->when($this->franchiseFilter, function ($query) {
                $query->where('franchise_id', $this->franchiseFilter);
            })
            ->with('franchise') // assuming you have a relationship defined
            ->paginate(10);

        $franchises = franchises::orderBy('franchise_name')->get();

        return view('livewire.admin.receptionst-manage', [
            'receptionists' => $receptionists,
            'franchises' => $franchises,
        ]);
    }
}
