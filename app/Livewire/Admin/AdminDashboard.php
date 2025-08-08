<?php

namespace App\Livewire\Admin;

use App\Models\franchises as Franchise;
use App\Models\Payment;
use App\Models\Receptioners as Receptioner;
use App\Models\Staff;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminDashboard extends Component
{
    #[Layout('components.layouts.admin-layout')]
    public $sortField = 'created_at';

    public function render(): View
    {
        $franchiseCount = Franchise::count();
        $staffCount = Staff::count();
        $receptionistCount = Receptioner::count();
        $totalPayments = Payment::sum('amount');

        return view('livewire.admin.admin-dashboard', [
            'franchiseCount' => $franchiseCount,
            'staffCount' => $staffCount,
            'receptionistCount' => $receptionistCount,
            'totalPayments' => $totalPayments,
        ]);
    }
}
