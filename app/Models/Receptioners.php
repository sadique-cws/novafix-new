<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Receptioners extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function franchise()
    {
        return $this->belongsTo(franchises::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'receptioners_id');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ReceptionersResetPasswordNotification($token));
    }
    public function getRememberTokenName()
    {
        return null; // Tells Laravel this model doesn't use remember_token
    }
    
    
    
}
