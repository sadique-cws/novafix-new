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

    protected $guarded = [];

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
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-avatar.png'); // Default image if none exists
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
        return $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->orWhere('contact', 'like', '%'.$search.'%');
    }
}
