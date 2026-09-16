<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'payment_id',
        'service_request_id',
        'amount_paid',
        'payment_method',
        'transaction_id',
        'received_by',
        'staff_id',
        'notes',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(Receptioners::class, 'received_by');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
