<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
    // app/Models/User.php
public function franchise()
{
    return $this->hasOne(Franchise::class);
}

public function receptioner()
{
    return $this->hasOne(Receptioners::class);
}

public function staff()
{
    return $this->hasOne(Staff::class);
}
// app/Models/User.php
public function isAdmin()
{
    return $this->is_admin;
}

public function isFranchise()
{
    return $this->is_franchise;
}

public function isStaff()
{
    return $this->is_staff;
}

public function isFrontdesk()
{
    return $this->is_frontdesk;
}

public function sendPasswordResetNotification($token)
{
    $this->notify(new CustomResetPassword($token));
}

}
