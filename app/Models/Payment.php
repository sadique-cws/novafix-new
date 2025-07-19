<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'service_request_id',
        'amount',
        'discount',
        'tax',
        'total_amount',
        'payment_method',
        'transaction_id',
        'status',
        'notes',
        'received_by',
    ];

   

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
        return $this->belongsTo(franchises::class);
    }

   
}
