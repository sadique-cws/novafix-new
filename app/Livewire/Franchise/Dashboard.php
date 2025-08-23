<?php

namespace App\Livewire\Franchise;

use App\Models\Franchise;
use App\Models\Payment;
use App\Models\Receptioners;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

#[Layout('components.layouts.franchise-layout')]
class Dashboard extends Component
{
    public $franchiseId;
    public $totalReceptionists;

    public function mount()
    {
        $this->franchiseId = Auth::guard('franchise')->user()->id;
    }

    public function render()
    {
        // ✅ Fetch receptioner IDs once
        $receptionerIds = Receptioners::where('franchise_id', $this->franchiseId)->pluck('id');

        // ✅ Stats & Orders
        $stats = $this->getStats($receptionerIds, $this->franchiseId);
        $recentOrders = $this->getRecentOrders($receptionerIds);

        return view('livewire.franchise.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }

    /**
     * Get dashboard stats with single cache key
     */
    protected function getStats($receptionerIds, $franchiseId)
    {
        return Cache::remember("franchise_stats_{$franchiseId}", 1800, function () use ($receptionerIds, $franchiseId) {
            return [
                'totalReceptionists' => $this->totalReceptionists = Receptioners::where('franchise_id', $franchiseId)->count(),

                'totalCustomers' => ServiceRequest::whereIn('receptioners_id', $receptionerIds)
                    ->distinct('contact')
                    ->count('contact'),

                'servicesCompleted' => ServiceRequest::whereIn('receptioners_id', $receptionerIds)
                    ->where('status', '100')
                    ->count(),

                'totalRevenue' => Payment::whereHas('serviceRequest', function ($query) use ($receptionerIds) {
                    $query->whereIn('receptioners_id', $receptionerIds);
                })
                    ->where('status', 'completed')
                    ->sum('total_amount'),
            ];
        });
    }

    /**
     * Get recent orders (not cached so you always see fresh orders)
     */
    protected function getRecentOrders($receptionerIds)
    {
        return ServiceRequest::with(['payment', 'serviceCategory'])
            ->whereIn('receptioners_id', $receptionerIds)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->service_code,
                    'customer' => $order->owner_name,
                    'service' => $order->serviceCategory->name,
                    'status' => $this->getStatusInfo($order->status),
                    'amount' => $order->payment ? $order->payment->total_amount : 0,
                ];
            });
    }

    /**
     * Map status codes to labels & styles
     */
    protected function getStatusInfo($status)
    {
        $statuses = [
            '100' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Completed'],
            '50'  => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'In Progress'],
            '90'  => ['class' => 'bg-red-100 text-red-800', 'text' => 'Cancelled'],
            '0'   => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pending'],
        ];

        return $statuses[$status] ?? $statuses['0'];
    }
}
