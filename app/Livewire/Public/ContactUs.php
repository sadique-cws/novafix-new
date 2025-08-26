<?php

namespace App\Livewire\Public;

use App\Models\Contact;
use Livewire\Component;

class ContactUs extends Component
{
    public $name, $phone, $company, $email, $subject, $message, $about_us;

    protected $rules = [
        'name' => 'required|string|max:100',
        'phone' => 'required|string|max:15',
        'company' => 'nullable|string|max:150',
        'email' => 'required|email',
        'subject' => 'required|string|max:150',
        'message' => 'required|string',
        'about_us' => 'nullable|string|max:150',
    ];

    public function save()
    {
        $this->validate();

        // Use the aliased model
        Contact::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'company' => $this->company,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'about_us' => $this->about_us,
        ]);

        session()->flash('success', 'Thank you for contacting us. We will get back to you soon!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.public.contact-us');
    }
}
