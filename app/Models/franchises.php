<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class franchises extends Authenticatable
{
   use HasFactory, Notifiable;
   protected $guarded = [];
   public function payments()
   {
      return $this->hasMany(Payment::class);
   }
}
