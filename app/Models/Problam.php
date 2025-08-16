<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problam extends Model
{
    protected $guarded = [];

    public function model()
    {
        return $this->belongsTo(DeviceModel::class, 'model_id');
    }

  
}
