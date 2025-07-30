<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $guarded = [];

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'service_categories_id'); // Adjust foreign key if needed
    }
}
