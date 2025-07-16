<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminDashboard extends Component
{
    #[Layout('components.layouts.admin-layout')]
    public $sortField = 'created_at';
    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
