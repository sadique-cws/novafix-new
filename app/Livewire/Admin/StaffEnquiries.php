<?php

namespace App\Livewire\Admin;

use App\Models\StaffEnquiry;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Staff Enquiries')]
#[Layout('components.layouts.admin-layout')]
class StaffEnquiries extends Component
{
    public $selectedEnquiry = null;
    public $showModal = false;

    public function viewEnquiry($id)
    {
        $this->selectedEnquiry = StaffEnquiry::with(['staff.franchise'])->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedEnquiry = null;
    }

    public function deleteEnquiry($id)
    {
        StaffEnquiry::destroy($id);
        if ($this->selectedEnquiry && $this->selectedEnquiry->id == $id) {
            $this->closeModal();
        }
        session()->flash('message', 'Enquiry deleted successfully.');
    }

    public function render()
    {
        $enquiries = StaffEnquiry::with('staff.franchise')->latest()->get();
        return view('livewire.admin.staff-enquiries', compact('enquiries'));
    }
}
