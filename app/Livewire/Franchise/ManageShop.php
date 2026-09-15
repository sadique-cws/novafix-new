<?php

namespace App\Livewire\Franchise;

use App\Models\Shop;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

#[Layout('components.layouts.franchise-layout')]
class ManageShop extends Component
{
    use WithPagination;

    public $shop_name, $owner_name, $contact, $email, $address, $gst_number, $shop_id;
    public $showModal = false;
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'shop_name' => 'required|string|max:255',
        'owner_name' => 'required|string|max:255',
        'contact' => 'required|string|max:15',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string',
        'gst_number' => 'nullable|string|max:15',
    ];

    public function openModal()
    {
        $this->reset(['shop_name', 'owner_name', 'contact', 'email', 'address', 'gst_number', 'shop_id']);
        $this->dispatch('open-modal', 'shopModal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', 'shopModal');
    }

    public function save()
    {
        $this->validate();

        Shop::updateOrCreate(
            ['id' => $this->shop_id],
            [
                'franchise_id' => Auth::guard('franchise')->user()->id,
                'shop_name' => $this->shop_name,
                'owner_name' => $this->owner_name,
                'contact' => $this->contact,
                'email' => $this->email,
                'address' => $this->address,
                'gst_number' => $this->gst_number,
            ]
        );

        $this->closeModal();
        session()->flash('message', $this->shop_id ? 'Shop updated successfully.' : 'Shop added successfully.');
    }

    public function render()
    {
        $shops = Shop::query()
            ->where('franchise_id', Auth::guard('franchise')->user()->id)
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('shop_name', 'like', '%' . $this->search . '%')
                      ->orWhere('owner_name', 'like', '%' . $this->search . '%')
                      ->orWhere('contact', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.franchise.manage-shop', [
            'shops' => $shops
        ]);
    }
}
