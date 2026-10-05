<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'shop_id',
        'customer_id',
        'service_request_id',
        'type',
        'amount',
        'description',
        'recorded_by',
        'recorded_by_type'
    ];

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
