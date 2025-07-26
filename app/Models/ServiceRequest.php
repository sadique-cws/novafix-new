<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $guarded = [];



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
    public function receptioner()
    {
        return $this->belongsTo(Receptioners::class, 'receptioners_id');
    }

  
   
}
