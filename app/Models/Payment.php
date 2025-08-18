<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{



    protected $guarded = [];


    public function receiver()
    {
        return $this->belongsTo(Staff::class, 'received_by');
    }
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }
    public function receivedBy()
    {
        return $this->belongsTo(Receptioners::class, 'received_by');
    }
    public function service()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }
    

  

   
   
}
