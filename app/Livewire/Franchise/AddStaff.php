<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServiceCategory;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
#[Title('Add Staff')]
#[Layout('components.layouts.franchise-layout')]

class AddStaff extends Component
{
    use WithFileUploads;
  

    // Form fields
    #[Rule('image|max:2048')]
    public $image;

    #[Rule('required|string|max:255')]
    public $name ;

    #[Rule('required|email|')]
    public $email ;

    #[Rule('required|string|max:20')]
    public $contact ;

    #[Rule('required|exists:service_categories,id')]
    public $service_categories_id ;

    #[Rule('required|numeric')]
    public $salary ;

    #[Rule('required|in:active,inactive')]
    public $status = 'active';

    #[Rule('required|string|max:12')]
    public $aadhar ;

    #[Rule('required|string|max:10')]
    public $pan ;

    #[Rule('required|string|min:6')]
    public $password;

    #[Rule('required|string')]
    public $address ;

    public function save()
    {
        $validated = $this->validate();


        // Handle image upload
        if ($this->image) {
            $validated['image'] = $this->image->store('/staff/images', 'public');
           
        }


        // Add franchise_id to validated data
        $validated['franchise_id'] = Auth::guard('franchise')->user()->id;
        $validated['password'] = bcrypt($this->password);

        // Create staff with all data including franchise_id
        Staff::create($validated);


        // Reset form
        $this->reset();

        session()->flash('success', 'Staff member added successfully!');
        $this->redirect('manage-staff', navigate: true);
    }

    public function render()
    {
        $categories = ServiceCategory::all();
        return view('livewire.franchise.add-staff', [
            'categories' => $categories
        ]);
    }
}
