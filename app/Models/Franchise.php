<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    //

   use HasFactory, Notifiable;

   protected $guarded = [];
   
   public function receptioners()
   {
      return $this->hasMany(Receptioners::class);
   }

   public function serviceRequests()
   {
      return $this->hasManyThrough(
         ServiceRequest::class,
         Receptioners::class,
         'franchise_id', // Foreign key on receptioners table
         'receptioners_id', // Foreign key on service_requests table
         'id', // Local key on franchises table
         'id' // Local key on receptioners table
      );
   }
   
   

   public function payments()
   {
      return $this->hasManyThrough(
         Payment::class,
         ServiceRequest::class,
         'receptioners_id', // Foreign key on service_requests table
         'service_request_id', // Foreign key on payments table
         'id', // Local key on receptioners table
         'id' // Local key on service_requests table
      )->whereHas('serviceRequest.receptioner', function ($query) {
         $query->where('franchise_id', $this->id);
      });
   }
   // public function payments()
   // {
   //    return $this->hasManyThrough(
   //       Payment::class,
   //       ServiceRequest::class,
   //       'receptioners_id', // Foreign key on service_requests table
   //       'service_request_id', // Foreign key on payments table
   //       'id', // Local key on franchises table
   //       'id' // Local key on service_requests table
   //    );
   // }
}
