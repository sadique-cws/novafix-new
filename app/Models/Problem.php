<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;


class Problem extends Model
{
    protected $guarded = [];

    public function model()
    {
        return $this->belongsTo(Model::class, 'model_id');
    }
}
