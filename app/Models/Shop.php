<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'shop_name',
        'owner_name',
        'contact',
        'email',
        'address',
        'gst_number',
    ];

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }
}
