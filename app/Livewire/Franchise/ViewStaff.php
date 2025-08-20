<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\Staff;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
#[Title('View Staff')]
#[Layout('components.layouts.franchise-layout')]

class ViewStaff extends Component
{
    public $staffId;
    public $staff;
    public $activeTab = 'details';
    public $chartType = 'bar';
    public $performanceRange = '6months';

    protected $listeners = ['refreshChart' => '$refresh'];

    public function mount($id)
    {
        $this->staffId = $id;
        $this->loadStaff();
    }

    public function loadStaff()
    {
        $this->staff = Staff::with(['serviceCategory', 'franchise'])
            ->where('franchise_id', Auth::guard('franchise')->user()->id)
            ->findOrFail($this->staffId);
    }

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updatedPerformanceRange()
    {
        $this->emit('refreshChart');
    }

    public function updatedChartType()
    {
        $this->emit('updateChart', ['type' => $this->chartType]);
    }

    public function getPerformanceDataProperty()
    {
        $endDate = now();
        $startDate = match ($this->performanceRange) {
            '1month' => now()->subMonth(),
            '3months' => now()->subMonths(3),
            '6months' => now()->subMonths(6),
            '1year' => now()->subYear(),
            default => now()->subMonths(6),
        };

        // Extend end date by one month for inclusive DatePeriod iteration
        $endDateInclusive = (clone $endDate)->modify('+1 month');

        // Completed services count grouped by month
        $servicesData = ServiceRequest::where('technician_id', $this->staffId)
            ->where('status', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('created_at')
            ->get()
            ->pluck('count', 'month');

        // Total revenue grouped by month
        $revenueData = ServiceRequest::where('technician_id', $this->staffId)
            ->where('status', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, SUM(service_amount) as total')
            ->groupBy('month')
            ->orderBy('created_at')
            ->get()
            ->pluck('total', 'month');

        $period = new \DatePeriod($startDate, new \DateInterval('P1M'), $endDateInclusive);

        $labels = $services = $revenues = [];

        foreach ($period as $date) {
            $month = $date->format('M Y');
            $labels[] = $month;
            $services[] = $servicesData[$month] ?? 0;
            $revenues[] = $revenueData[$month] ?? 0;
        }

        return [
            'labels' => $labels,
            'services' => $services,
            'revenues' => $revenues,
            'total_services' => array_sum($services),
            'total_revenue' => array_sum($revenues),
            'performance_change' => $this->calculatePerformanceChange($services),
            'revenue_change' => $this->calculatePerformanceChange($revenues),
        ];
    }

    protected function calculatePerformanceChange(array $data)
    {
        $count = count($data);
        if ($count < 2) return 0;

        $third = max(1, intdiv($count, 3));

        $recent = array_slice($data, -$third);
        $previous = array_slice($data, -2 * $third, $third);

        if (count($previous) === 0) return 0;

        $recentAvg = array_sum($recent) / count($recent);
        $previousAvg = array_sum($previous) / count($previous);

        return $previousAvg > 0 ? round((($recentAvg - $previousAvg) / $previousAvg * 100), 1) : 0;
    }

    public function render()
    {
        return view('livewire.franchise.view-staff', [
            'staff' => $this->staff,
            'activeTab' => $this->activeTab,
            'performanceData' => $this->performanceData,
            'chartType' => $this->chartType,
            'performanceRange' => $this->performanceRange,
        ]);
    }
}
