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
}
