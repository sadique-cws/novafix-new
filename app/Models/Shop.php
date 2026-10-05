<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'shop_name',
        'owner_name',
        'contact',
        'email',
        'address',
        'gst_number',
        'balance',
    ];

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }

    public function refreshBalance()
    {
        $debits = $this->ledgers()->where('type', 'debit')->sum('amount');
        $credits = $this->ledgers()->where('type', 'credit')->sum('amount');
        
        $this->update(['balance' => $debits - $credits]);
        
        return $this->balance;
    }
}
