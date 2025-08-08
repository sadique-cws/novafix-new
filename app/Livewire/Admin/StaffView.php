<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Staff;

#[Layout('components.layouts.admin-layout')]
class StaffView extends Component
{
    public Staff $staff;

    public function mount($id)
    {
        $this->staff = Staff::with(['franchise', 'serviceCategory'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.staff-view');
    }
}
