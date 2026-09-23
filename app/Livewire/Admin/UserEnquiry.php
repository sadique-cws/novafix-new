<?php

namespace App\Livewire\Admin;

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('User Enquiries')]
#[Layout('components.layouts.admin-layout')]
class UserEnquiry extends Component
{
    public $selectedEnquiry = null;
    public $showModal = false;

    public function viewEnquiry($id)
    {
        $this->selectedEnquiry = Contact::find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedEnquiry = null;
    }

    public function deleteEnquiry($id)
    {
        Contact::destroy($id);
        if ($this->selectedEnquiry && $this->selectedEnquiry->id == $id) {
            $this->closeModal();
        }
        session()->flash('message', 'Enquiry deleted successfully.');
    }

    public function render()
    {
        $enquiries = Contact::latest()->get();
        return view('livewire.admin.user-enquiry', compact('enquiries'));
    }
}
