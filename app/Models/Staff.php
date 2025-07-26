<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Staff extends Authenticatable
{
  protected $guarded = [];

    public function franchise()
    {
        return $this->belongsTo(Franchises::class, 'franchise_id');
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_categories_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-avatar.png'); // Default image if none exists
    }
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'technician_id');
    }

    // Add this relationship if you need to access the service category
  
}
