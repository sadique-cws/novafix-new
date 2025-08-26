<?php

namespace App\Livewire\Admin;

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class UserEnquiry extends Component
{
    public function render()
    {
        $enquiries = Contact::all();
        return view('livewire.admin.user-enquiry', compact('enquiries'));
    }
}
