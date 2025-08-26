<?php

namespace App\Livewire\Admin;

use App\Models\StaffEnquiry;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class StaffEnquiries extends Component
{
    public function render()
    {
        $enquiries = StaffEnquiry::all();
        return view('livewire.admin.staff-enquiries', compact('enquiries'));
    }
}
