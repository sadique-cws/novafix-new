<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'name',
        'contact',
        'email',
    ];

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'contact', 'contact')
                    ->where('franchise_id', $this->franchise_id);
    }
}
