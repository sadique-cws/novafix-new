<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'receptioners_id',
        'technician_id',
        'service_categories_id',
        'service_code',
        'owner_name',
        'product_name',
        'email',
        'contact',
        'brand',
        'serial_no',
        'MAC',
        'color',
        'service_amount',
        'problem',
        'remark',
        'status',
        'last_update',
        'delivered_by',
        'delivery_status',
        'estimate_delivery',
        'date_of_delivery',
        'image'
    ];

    protected $casts = [
        'last_update' => 'datetime',
        'estimate_delivery' => 'datetime',
        'date_of_delivery' => 'datetime',
        'service_amount' => 'decimal:2',
        'status' => 'decimal:2'
    ];

    public function receptionist()
    {
        return $this->belongsTo(Receptioners::class, 'receptioners_id');
    }

    public function technician()
    {
        return $this->belongsTo(Staff::class, 'technician_id');
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_categories_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function deliveredBy()
    {
        return $this->belongsTo(Receptioners::class, 'delivered_by');
    }
   
}
