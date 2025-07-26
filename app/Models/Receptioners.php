<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Receptioners extends Authenticatable
{
    protected $guarded = [];

    public function franchise()
    {
        return $this->belongsTo(franchises::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'receptioners_id');
    }
}
