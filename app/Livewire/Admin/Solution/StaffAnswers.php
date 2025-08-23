<?php

namespace App\Livewire\Admin\Solution;

use App\Models\userAnswer;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-layout')]
class StaffAnswers extends Component
{
    public function render()
    {
        
        return view('livewire.admin.solution.staff-answers');
    }
}
