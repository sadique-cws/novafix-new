<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Staff extends Authenticatable
{
    use HasFactory;
    use Notifiable;


    protected $fillable = [
        'franchise_id',
        'name',
        'email',
        'contact',
        'salary',
        'service_categories_id',
        'status',
        'image_url',
        'image_file_id',
        'aadhar',
        'pan',
        'address',
        'password',
    ];

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
        return $this->belongsTo(Franchise::class, 'franchise_id');
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_categories_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function answers()
    {
        return $this->HasMany(userAnswer::class, 'user_id');
    }
    public function getImageUrlAttribute($value)
    {
        $raw = $this->attributes['image_url'] ?? $value;
        if (!empty($raw)) {
            if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
                return $raw;
            }
            return asset('storage/' . ltrim($raw, '/'));
        }
        return null;
    }

    public function getImageAttribute()
    {
        return $this->image_url;
    }
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'technician_id');
    }

    /**
     * Scope a query to search staffs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('contact', 'like', '%' . $search . '%');
    }

}
