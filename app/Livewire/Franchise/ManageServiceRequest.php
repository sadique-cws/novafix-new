<?php

namespace App\Livewire\Franchise;

use Livewire\Component;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.franchise-layout')]
class ManageServiceRequest extends Component
{
    public $serviceRequests;
    public $serviceRequestId, $franchise_id, $reciptionist_id, $user_id, $technician_id;
    public $service_code, $owner_name, $product_name, $email, $contact, $brand;
    public $type_id, $serial_no, $MAC, $color, $service_amount, $problem, $remark;
    public $status, $last_update, $delivered_by, $estimate_delivery, $date_of_delivery;
    public $image;

    public function mount()
    {
        $this->serviceRequests = ServiceRequest::all();
    }

    public function render()
    {
        return view('livewire.franchise.manage-service-request');
    }

    public function createServiceRequest()
    {
        $this->validate([
            'service_code' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'problem' => 'required|string|max:255',
        ]);

        ServiceRequest::create([
            'franchise_id' => $this->franchise_id,
            'reciptionist_id' => $this->reciptionist_id,
            'user_id' => $this->user_id,
            'technician_id' => $this->technician_id,
            'service_code' => $this->service_code,
            'owner_name' => $this->owner_name,
            'product_name' => $this->product_name,
            'email' => $this->email,
            'contact' => $this->contact,
            'brand' => $this->brand,
            'type_id' => $this->type_id,
            'serial_no' => $this->serial_no,
            'MAC' => $this->MAC,
            'color' => $this->color,
            'service_amount' => $this->service_amount,
            'problem' => $this->problem,
            'remark' => $this->remark,
            'status' => $this->status,
            'last_update' => $this->last_update,
            'delivered_by' => $this->delivered_by,
            'estimate_delivery' => $this->estimate_delivery,
            'date_of_delivery' => $this->date_of_delivery,
            'image' => $this->image,
        ]);

        $this->reset();
        $this->serviceRequests = ServiceRequest::all();
    }

    public function deleteServiceRequest($id)
    {
        ServiceRequest::find($id)->delete();
        $this->serviceRequests = ServiceRequest::all();
    }
}
