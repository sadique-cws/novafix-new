<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model As BaseModel;

class Model extends BaseModel
{
    protected $guarded = [];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
