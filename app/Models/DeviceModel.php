<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    protected $guarded = [];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
